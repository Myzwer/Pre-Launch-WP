import "../css/tailwind.css";
import "../css/frontend.css";
import "./accordion";

import { initPrimaryNav } from "./navbar";
import { initHeaderVideoPause } from "./header-video";

const boot = (): void => {
	initPrimaryNav();
	initHeaderVideoPause();
};

if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", boot);
} else {
	boot();
}


