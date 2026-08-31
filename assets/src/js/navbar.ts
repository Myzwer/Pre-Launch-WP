/**
 * Primary navigation behavior (2-level depth).
 *
 * Contract hooks (markup / walker contract):
 * - .nav-hamburger (button) controls #nav-panel (div)
 * - li[data-nav-item] contains button[data-nav-toggle] + div[data-nav-submenu]
 *
 * Behavior:
 * - Mobile panel: hamburger toggles; starts collapsed on load.
 * - Desktop: panel is always visible (CSS enforces too).
 * - Submenus: click-to-toggle (disclosure), accordion at top level.
 * - Escape closes open submenu first; then closes panel and returns focus to hamburger.
 * - Click outside closes everything.
 *
 * Animations:
 * - Uses Web Animations API for panel/submenu slide (height) when motion is allowed.
 * - Hamburger + caret are styled via CSS based on aria-expanded / .is-open classes.
 *
 * @param {Document|HTMLElement} root - Root document or element used to scope navigation queries.
 */
export function initPrimaryNav(root: Document | HTMLElement = document): void {
	// ---------------------------------------------------------------------
	// Config (clarity > cleverness)
	// ---------------------------------------------------------------------

	const SELECTORS = {
		nav: ".nav",
		hamburger: ".nav-hamburger",
		brand: ".nav-brand",
		topItem: "[data-nav-item]",
		toggle: "[data-nav-toggle]",
		submenu: "[data-nav-submenu]",
		siteHeader: ".site-header",
	} as const;

	/**
	 * README:BREAKPOINT_SYNC
	 * If you change the desktop breakpoint in CSS, update DESKTOP_MEDIA_QUERY here too.
	 */
	const DESKTOP_MEDIA_QUERY = "(min-width: 1024px)";

	// Animation tuning (only applies when motion is allowed and on mobile)
	const ANIM_DURATION_MS = 220;
	const ANIM_EASING = "cubic-bezier(0.2, 0, 0, 1)";

	// ---------------------------------------------------------------------
	// Setup / element discovery
	// ---------------------------------------------------------------------

	const nav =
		(root instanceof Document ? root : root.ownerDocument)?.querySelector(SELECTORS.nav) ??
		(root as HTMLElement).querySelector?.(SELECTORS.nav);

	if (!nav) return;

	const doc = nav.ownerDocument;
	const win = doc.defaultView;
	if (!win) return;

	const hamburger = nav.querySelector<HTMLButtonElement>(SELECTORS.hamburger);
	const panelId = hamburger?.getAttribute("aria-controls") || "nav-panel";
	const panel = nav.querySelector<HTMLElement>(`#${CSS.escape(panelId)}`);

	const topItems = Array.from(nav.querySelectorAll<HTMLElement>(SELECTORS.topItem));

	const prefersReducedMotion = win.matchMedia("(prefers-reduced-motion: reduce)").matches;
	const desktopMql = win.matchMedia(DESKTOP_MEDIA_QUERY);

	type NavItemParts = {
		toggle: HTMLButtonElement | null;
		submenu: HTMLElement | null;
	};

	// --- helpers -------------------------------------------------------------

	/**
	 * Given a top-level nav item, return its disclosure toggle and submenu element.
	 *
	 * @param {HTMLElement} item - A top-level nav <li> element marked with [data-nav-item].
	 * @return {NavItemParts} The associated toggle + submenu for that item.
	 */
	const getItemParts = (item: HTMLElement): NavItemParts => {
		const toggle = item.querySelector<HTMLButtonElement>(SELECTORS.toggle);
		const submenu = item.querySelector<HTMLElement>(SELECTORS.submenu);
		return { toggle, submenu };
	};

	/**
	 * Set aria-expanded state on a disclosure button.
	 *
	 * @param {HTMLButtonElement} toggle - The disclosure button controlling a submenu.
	 * @param {boolean} expanded - Expanded state.
	 */
	const setExpanded = (toggle: HTMLButtonElement, expanded: boolean): void => {
		toggle.setAttribute("aria-expanded", expanded ? "true" : "false");
	};

	const updateMenuLabel = (open: boolean): void => {
		const menuLabel = hamburger?.querySelector("[data-nav-menu-label]");
		if (menuLabel) {
			menuLabel.textContent = open ? "Close menu" : "Menu";
		}
	};

	/**
	 * Cancel any running Web Animations API animation on an element.
	 * Used to prevent overlapping height animations and stale computed styles.
	 *
	 * @param {HTMLElement} el - Element whose active navigation animation should be cancelled.
	 */
	const stopRunningAnimation = (el: HTMLElement): void => {
		const running = (el as any).__navAnim as Animation | undefined;
		if (!running) return;

		try {
			running.cancel();
		} catch {
			// ignore
		} finally {
			(el as any).__navAnim = undefined;
		}
	};

	/**
	 * Animate an element's height open or closed using the Web Animations API.
	 * Automatically cleans up inline styles and cancels the animation to prevent
	 * fill-mode artifacts that can freeze layout.
	 *
	 * @param {HTMLElement} el - The element whose height should be animated.
	 * @param {boolean} open - Whether the element is opening (true) or closing (false).
	 * @return {Promise<void>} Resolves when the animation cycle completes.
	 */
	const animateHeight = async (el: HTMLElement, open: boolean): Promise<void> => {
		// Desktop doesn't animate (menus are always "present"); bail early.
		if (desktopMql.matches) return;

		// If reduced motion, do the instantaneous toggle.
		if (prefersReducedMotion) return;

		stopRunningAnimation(el);

		// Ensure it can be measured.
		const wasHidden = el.hidden;
		if (open && wasHidden) el.hidden = false;

		const startHeight = open ? 0 : el.getBoundingClientRect().height;

		// If closing and already at 0, just finish.
		if (!open && startHeight <= 0.5) {
			el.hidden = true;
			return;
		}

		// Temporarily fix height for a clean animation.
		el.style.overflow = "hidden";
		el.style.height = `${startHeight}px`;

		// Force reflow so the browser picks up the height before animating.
		el.offsetHeight;

		const endHeight = open ? el.scrollHeight : 0;

		const anim = el.animate(
			[{ height: `${startHeight}px` }, { height: `${endHeight}px` }],
			{
				duration: ANIM_DURATION_MS,
				easing: ANIM_EASING,
				fill: "forwards",
			}
		);

		(el as any).__navAnim = anim;

		let wasCancelled = false;

		try {
			await anim.finished;
		} catch {
			wasCancelled = true;
		} finally {
			(el as any).__navAnim = undefined;

			// CRITICAL: release WAAPI "forwards" effect so layout can return to height:auto
			// README:WAAPI_CANCEL
			try {
				anim.cancel();
			} catch {
				// ignore
			}

			// Release inline sizing so the element can grow naturally again.
			el.style.removeProperty("height");
			el.style.removeProperty("overflow");

			// Only hide if we were closing and we weren't cancelled mid-flight.
			if (!open && !wasCancelled) {
				el.hidden = true;
			}
		}
	};

	/**
	 * Close a single top-level submenu item.
	 *
	 * @param {HTMLElement} item - The top-level nav item to close.
	 * @return {Promise<void>} Resolves after any required animation completes.
	 */
	const closeItem = async (item: HTMLElement): Promise<void> => {
		const { toggle, submenu } = getItemParts(item);
		if (!toggle || !submenu) return;

		setExpanded(toggle, false);
		item.classList.remove("is-open");

		if (submenu.hidden) return;

		await animateHeight(submenu, false);

		// Always hide after closing.
		// (On desktop animateHeight() intentionally doesn't animate, so we must still hide.)
		submenu.hidden = true;
	};

	/**
	 * Open a single top-level submenu item (accordion behavior).
	 *
	 * @param {HTMLElement} item - The top-level nav item to open.
	 * @return {Promise<void>} Resolves after any required animation completes.
	 */
	const openItem = async (item: HTMLElement): Promise<void> => {
		const { toggle, submenu } = getItemParts(item);
		if (!toggle || !submenu) return;

		// Accordion: close other open items at this level.
		await Promise.all(
			topItems.map((other) => (other !== item ? closeItem(other) : Promise.resolve()))
		);

		setExpanded(toggle, true);
		item.classList.add("is-open");

		if (!submenu.hidden) return;

		submenu.hidden = false;

		if (prefersReducedMotion) return;

		await animateHeight(submenu, true);
	};

	/**
	 * Toggle a single top-level submenu item open/closed.
	 *
	 * @param {HTMLElement} item - The top-level nav item to toggle.
	 * @return {Promise<void>} Resolves after any required animation completes.
	 */
	const toggleItem = async (item: HTMLElement): Promise<void> => {
		const { toggle } = getItemParts(item);
		if (!toggle) return;

		const expanded = toggle.getAttribute("aria-expanded") === "true";
		if (expanded) {
			await closeItem(item);
		} else {
			await openItem(item);
		}
	};

	/**
	 * Close all open submenus.
	 *
	 * @return {Promise<void>} Resolves after all close operations complete.
	 */
	const closeAllSubmenus = async (): Promise<void> => {
		await Promise.all(topItems.map(closeItem));
	};

	/**
	 * Open or close the mobile panel.
	 *
	 * @param {boolean} open - Whether to open the panel.
	 * @return {Promise<void>} Resolves after any required animation completes.
	 */
	const setPanelOpen = async (open: boolean): Promise<void> => {
		if (!hamburger || !panel) return;

		hamburger.setAttribute("aria-expanded", open ? "true" : "false");
		hamburger.classList.toggle("is-open", open);
		updateMenuLabel(open && !desktopMql.matches);

		// Styling hook (optional): used for backdrop + scroll lock in CSS.
		doc.body.classList.toggle("nav-open", open);

		if (desktopMql.matches) {
			// Desktop: panel is always visible, regardless of "open" state.
			panel.hidden = false;
			if (!open) await closeAllSubmenus();
			return;
		}

		if (open) {
			panel.hidden = false;
			if (!prefersReducedMotion) {
				await animateHeight(panel, true);
			}
		} else {
			if (!prefersReducedMotion) {
				await animateHeight(panel, false);
			}
			panel.hidden = true;
			await closeAllSubmenus();
		}
	};

	/**
	 * Synchronous "hard close" used for navigation clicks (Safari repaint issue).
	 * Avoids waiting for WAAPI animations so the UI updates immediately.
	 *
	 * @return {void}
	 */
	const hardCloseAllSubmenus = (): void => {
		for (const item of topItems) {
			const { toggle, submenu } = getItemParts(item);
			if (!toggle || !submenu) continue;

			setExpanded(toggle, false);
			item.classList.remove("is-open");

			// Stop any in-flight animations and reset layout styles.
			submenu.getAnimations?.().forEach((a) => a.cancel());
			submenu.style.removeProperty("height");
			submenu.style.removeProperty("overflow");

			submenu.hidden = true;
		}
	};

	/**
	 * Synchronous panel close used for navigation clicks.
	 *
	 * @return {void}
	 */
	const hardClosePanel = (): void => {
		if (!hamburger || !panel) return;

		hamburger.setAttribute("aria-expanded", "false");
		hamburger.classList.remove("is-open");
		doc.body.classList.remove("nav-open");
		updateMenuLabel(false);

		panel.getAnimations?.().forEach((a) => a.cancel());
		panel.style.removeProperty("height");
		panel.style.removeProperty("overflow");

		panel.hidden = true;
	};

	// ---------------------------------------------------------------------
	// README:SAFARI_LOGO_NAV
	// Mobile Safari may not repaint UI state changes before navigation.
	// If the panel is open and the user taps the brand, force-close synchronously,
	// then navigate explicitly so it never appears to "hang."
	// ---------------------------------------------------------------------

	const brandLink =
		nav.closest(SELECTORS.siteHeader)?.querySelector<HTMLAnchorElement>(SELECTORS.brand) ??
		null;

	brandLink?.addEventListener("click", (e) => {
		// Only care on mobile when the panel is currently open.
		if (desktopMql.matches) return;

		const panelOpen = hamburger?.getAttribute("aria-expanded") === "true";
		if (!panelOpen) return;

		const href = brandLink.getAttribute("href");
		if (!href) return;

		e.preventDefault();

		hardCloseAllSubmenus();
		hardClosePanel();

		// Navigate after UI update
		win.location.assign(href);
	});

	// --- init ---------------------------------------------------------------

	if (hamburger && panel) {
		if (desktopMql.matches) {
			// Desktop starts "open" (panel visible), with all submenus closed.
			hamburger.setAttribute("aria-expanded", "false");
			hamburger.classList.remove("is-open");
			panel.hidden = false;
			doc.body.classList.remove("nav-open");
			void closeAllSubmenus();
		} else {
			void setPanelOpen(false);
		}
	}

	// Keep state sane when crossing breakpoint.
	desktopMql.addEventListener("change", (e) => {
		if (e.matches) {
			// Entering desktop: force panel visible and reset open state.
			if (panel) panel.hidden = false;
			if (hamburger) {
				hamburger.setAttribute("aria-expanded", "false");
				hamburger.classList.remove("is-open");
				updateMenuLabel(false);
			}
			doc.body.classList.remove("nav-open");
			void closeAllSubmenus();
		} else {
			// Entering mobile: always start closed.
			void setPanelOpen(false);
		}
	});

	// --- events -------------------------------------------------------------

	// Hamburger toggle (mobile)
	hamburger?.addEventListener("click", async () => {
		if (!hamburger || !panel) return;

		const open = hamburger.getAttribute("aria-expanded") === "true";
		await setPanelOpen(!open);
	});

	// Top-level submenu toggles
	topItems.forEach((item) => {
		const { toggle } = getItemParts(item);
		if (!toggle) return;

		toggle.addEventListener("click", async () => {
			// If the mobile panel is closed, open it first.
			if (!desktopMql.matches && panel?.hidden) {
				await setPanelOpen(true);
			}
			await toggleItem(item);
		});
	});

	// Click outside closes (mobile: closes panel + submenus; desktop: closes submenus)
	doc.addEventListener("click", (e) => {
		const target = e.target as Node | null;
		if (!target) return;

		// Ignore clicks inside the nav.
		if (nav.contains(target)) return;

		void closeAllSubmenus();

		if (!desktopMql.matches) {
			const panelOpen = hamburger?.getAttribute("aria-expanded") === "true";
			if (panelOpen) void setPanelOpen(false);
		}
	});

	const isMobilePanelOpen = (): boolean =>
		!desktopMql.matches && hamburger?.getAttribute("aria-expanded") === "true";

	const getNavFocusable = (): HTMLElement[] => {
		const candidates = nav.querySelectorAll<HTMLElement>(
			'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'
		);

		return Array.from(candidates).filter((el) => {
			if (el.closest("[hidden]")) {
				return false;
			}

			return el.getClientRects().length > 0;
		});
	};

	// Tab stays inside the open mobile panel. Escape closes submenus, then the panel.
	doc.addEventListener("keydown", (e) => {
		if (e.key === "Tab" && isMobilePanelOpen()) {
			const items = getNavFocusable();
			if (items.length === 0) {
				return;
			}

			const first = items[0];
			const last = items[items.length - 1];
			const active = doc.activeElement;

			if (e.shiftKey) {
				if (active === first || (active instanceof Node && !nav.contains(active))) {
					e.preventDefault();
					last.focus();
				}
			} else if (active === last) {
				e.preventDefault();
				first.focus();
			}

			return;
		}

		if (e.key !== "Escape") return;

		const openSubmenu = topItems.find((item) => item.classList.contains("is-open"));
		if (openSubmenu) {
			e.preventDefault();
			void closeAllSubmenus();
			return;
		}

		const panelOpen = hamburger?.getAttribute("aria-expanded") === "true";
		if (panelOpen && !desktopMql.matches) {
			e.preventDefault();
			void setPanelOpen(false);
			hamburger?.focus();
		}
	});
}
