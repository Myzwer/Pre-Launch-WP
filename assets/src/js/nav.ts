/**
 * Primary navigation behavior (2-level depth).
 *
 * Contract hooks:
 * - .nav-hamburger (button) controls #nav-panel (div)
 * - li[data-nav-item] contains button[data-nav-toggle] + div[data-nav-submenu]
 *
 * Behavior:
 * - Mobile panel: hamburger toggles; starts collapsed on load.
 * - Desktop: panel is always visible (we unhide on init; CSS can also enforce).
 * - Submenus: click-to-toggle (disclosure), accordion at top level.
 * - Escape closes open submenu first; then closes panel.
 * - Click outside closes everything.
 *
 *  @param {Document|HTMLElement} root - Root document or element used to scope navigation queries.
 */
export function initPrimaryNav(root: Document | HTMLElement = document): void {
	const nav =
		(root instanceof Document ? root : root.ownerDocument)?.querySelector(".nav") ??
		(root as HTMLElement).querySelector?.(".nav");

	if (!nav) return;

	const doc = nav.ownerDocument;

	const hamburger = nav.querySelector<HTMLButtonElement>(".nav-hamburger");
	const panelId = hamburger?.getAttribute("aria-controls") || "nav-panel";
	const panel = nav.querySelector<HTMLElement>(`#${CSS.escape(panelId)}`);

	const topItems = Array.from(nav.querySelectorAll<HTMLElement>("[data-nav-item]"));

	// --- helpers -------------------------------------------------------------

	const getItemParts = (item: HTMLElement) => {
		const toggle = item.querySelector<HTMLButtonElement>("[data-nav-toggle]");
		const submenu = item.querySelector<HTMLElement>("[data-nav-submenu]");
		return { toggle, submenu };
	};

	const setExpanded = (toggle: HTMLButtonElement, expanded: boolean) => {
		toggle.setAttribute("aria-expanded", expanded ? "true" : "false");
	};

	const closeItem = (item: HTMLElement) => {
		const { toggle, submenu } = getItemParts(item);
		if (!toggle || !submenu) return;

		setExpanded(toggle, false);
		submenu.hidden = true;
		item.classList.remove("is-open");
	};

	const openItem = (item: HTMLElement) => {
		const { toggle, submenu } = getItemParts(item);
		if (!toggle || !submenu) return;

		// Accordion: close other open items at this level.
		topItems.forEach((other) => {
			if (other !== item) closeItem(other);
		});

		setExpanded(toggle, true);
		submenu.hidden = false;
		item.classList.add("is-open");
	};

	const toggleItem = (item: HTMLElement) => {
		const { toggle, submenu } = getItemParts(item);
		if (!toggle || !submenu) return;

		const expanded = toggle.getAttribute("aria-expanded") === "true";
		expanded ? closeItem(item) : openItem(item);
	};

	const closeAllSubmenus = () => {
		topItems.forEach(closeItem);
	};

	const setPanelOpen = (open: boolean) => {
		if (!hamburger || !panel) return;

		hamburger.setAttribute("aria-expanded", open ? "true" : "false");
		panel.hidden = !open;

		// styling hook (optional)
		nav.classList.toggle("nav-panel-open", open);

		// Bulletproof backdrop + scroll lock hook
		document.body.classList.toggle("nav-open", open);

		if (!open) closeAllSubmenus();
	};

	// --- init ---------------------------------------------------------------

	console.log("[nav] init", {
		foundNav: !!nav,
		foundHamburger: !!hamburger,
		panelId,
		foundPanel: !!panel,
		topItems: topItems.length,
	});

	// Initialize panel state:
	// - Mobile: start collapsed
	// - Desktop: start visible
	if (hamburger && panel) {
		const isDesktop = window.matchMedia("(min-width: 1024px)").matches;

		if (isDesktop) {
			hamburger.setAttribute("aria-expanded", "false");
			panel.hidden = false;
			nav.classList.remove("nav-panel-open");
			closeAllSubmenus();
		} else {
			setPanelOpen(false);
		}

		console.log("[nav] init panel", {
			isDesktop,
			panelHidden: panel.hidden,
			hamburgerExpanded: hamburger.getAttribute("aria-expanded"),
		});
	}

	// --- events -------------------------------------------------------------

	// Hamburger click
	hamburger?.addEventListener("click", () => {
		if (!hamburger || !panel) return;

		const open = hamburger.getAttribute("aria-expanded") === "true";
		setPanelOpen(!open);

		console.log("[nav] hamburger", {
			nextOpen: !open,
			panelHidden: panel.hidden,
		});
	});

	// Submenu toggle clicks (event delegation)
	nav.addEventListener("click", (e) => {
		const target = e.target as HTMLElement | null;
		if (!target) return;

		const toggle = target.closest<HTMLButtonElement>("[data-nav-toggle]");
		if (!toggle) return;

		const item = toggle.closest<HTMLElement>("[data-nav-item]");
		if (!item) return;

		e.preventDefault();

		console.log("[nav] submenu toggle", {
			controls: toggle.getAttribute("aria-controls"),
			expandedBefore: toggle.getAttribute("aria-expanded"),
		});

		toggleItem(item);

		console.log("[nav] submenu after", {
			expandedAfter: toggle.getAttribute("aria-expanded"),
		});
	});

	// Click outside closes
	doc.addEventListener("click", (e) => {
		const target = e.target as Node | null;
		if (!target) return;
		if (nav.contains(target)) return;

		closeAllSubmenus();

		if (hamburger && panel && hamburger.getAttribute("aria-expanded") === "true") {
			setPanelOpen(false);
			console.log("[nav] outside click -> close panel");
		}
	});

	// Escape closes
	doc.addEventListener("keydown", (e) => {
		if (e.key !== "Escape") return;

		const anyOpen = topItems.some((item) => item.classList.contains("is-open"));
		const panelOpen = hamburger?.getAttribute("aria-expanded") === "true";

		if (anyOpen) {
			e.preventDefault();
			closeAllSubmenus();
			console.log("[nav] escape -> close submenus");
			return;
		}

		if (panelOpen) {
			e.preventDefault();
			setPanelOpen(false);
			hamburger?.focus();
			console.log("[nav] escape -> close panel");
		}
	});
}
