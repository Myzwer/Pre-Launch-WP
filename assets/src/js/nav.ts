/**
 * Primary navigation behavior (2-level depth).
 *
 * Contract hooks:
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
	const nav =
		(root instanceof Document ? root : root.ownerDocument)?.querySelector(".nav") ??
		(root as HTMLElement).querySelector?.(".nav");

	if (!nav) return;

	const doc = nav.ownerDocument;
	const win = doc.defaultView;
	if (!win) return;

	const hamburger = nav.querySelector<HTMLButtonElement>(".nav-hamburger");
	const panelId = hamburger?.getAttribute("aria-controls") || "nav-panel";
	const panel = nav.querySelector<HTMLElement>(`#${CSS.escape(panelId)}`);

	const topItems = Array.from(nav.querySelectorAll<HTMLElement>("[data-nav-item]"));

	const prefersReducedMotion = win.matchMedia("(prefers-reduced-motion: reduce)").matches;
	const desktopMql = win.matchMedia("(min-width: 1024px)"); // SEARCHME: keep in sync with CSS breakpoint

	// --- helpers -------------------------------------------------------------

	const getItemParts = (item: HTMLElement) => {
		const toggle = item.querySelector<HTMLButtonElement>("[data-nav-toggle]");
		const submenu = item.querySelector<HTMLElement>("[data-nav-submenu]");
		return { toggle, submenu };
	};

	const setExpanded = (toggle: HTMLButtonElement, expanded: boolean) => {
		toggle.setAttribute("aria-expanded", expanded ? "true" : "false");
	};

	const stopRunningAnimation = (el: HTMLElement) => {
		const running = (el as any).__navAnim as Animation | undefined;
		if (running) {
			try {
				running.cancel();
			} catch {
				// ignore
			}
			(el as any).__navAnim = undefined;
		}
	};

	const animateHeight = async (el: HTMLElement, open: boolean): Promise<void> => {
		// Desktop doesn't animate (menus are always "present"); bail early.
		if (desktopMql.matches) return;

		// If reduced motion, do the instantaneous toggle.
		if (prefersReducedMotion) return;

		stopRunningAnimation(el);

		// Ensure it can be measured.
		const startingHidden = el.hidden;
		if (open && startingHidden) el.hidden = false;

		const startHeight = open ? 0 : el.getBoundingClientRect().height;
		// If closing and already at 0, just finish.
		if (!open && startHeight <= 0.5) return;

		// Temporarily fix height for a clean animation.
		el.style.overflow = "hidden";
		el.style.height = `${startHeight}px`;

		// Force reflow so the browser picks up the height before animating.
		el.offsetHeight;

		const endHeight = open ? el.scrollHeight : 0;

		const anim = el.animate(
			[{ height: `${startHeight}px` }, { height: `${endHeight}px` }],
			{
				duration: 220,
				easing: "cubic-bezier(0.2, 0, 0, 1)",
				fill: "forwards",
			}
		);

		(el as any).__navAnim = anim;

		try {
			await anim.finished;
		} catch {
			// cancelled
			return;
		} finally {
			(el as any).__navAnim = undefined;
		}

		el.style.removeProperty("height");
		el.style.removeProperty("overflow");

		if (!open) el.hidden = true;
	};

	const closeItem = async (item: HTMLElement): Promise<void> => {
		const { toggle, submenu } = getItemParts(item);
		if (!toggle || !submenu) return;

		setExpanded(toggle, false);
		item.classList.remove("is-open");

		if (submenu.hidden) return;

		await animateHeight(submenu, false);
		// If reduced motion, the animateHeight() no-ops, so do the state change.
		if (prefersReducedMotion) submenu.hidden = true;
	};

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

	const closeAllSubmenus = async (): Promise<void> => {
		await Promise.all(topItems.map(closeItem));
	};

	const setPanelOpen = async (open: boolean): Promise<void> => {
		if (!hamburger || !panel) return;

		hamburger.setAttribute("aria-expanded", open ? "true" : "false");
		hamburger.classList.toggle("is-open", open);

		// Styling hook (optional)
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

	// Escape closes submenus first; then panel.
	doc.addEventListener("keydown", (e) => {
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
