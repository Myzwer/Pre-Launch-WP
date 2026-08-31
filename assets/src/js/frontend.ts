import "../css/tailwind.css";
import "../css/frontend.css";
import "./accordion";

import { initPrimaryNav } from "./navbar";
import { initHeaderVideoPause } from "./header-video";

document.addEventListener("DOMContentLoaded", () => {
	initPrimaryNav();
	initHeaderVideoPause();
});


