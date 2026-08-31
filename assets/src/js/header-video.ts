/**
 * Pause/play control for decorative looping header videos.
 *
 * The button is rendered in the video header template and stays fixed in the
 * bottom-right so it remains available while the video is moving (WCAG 2.2.2).
 * Reduced-motion users never see the video or the control (CSS).
 */

const STORAGE_KEY = "prelaunch-header-video-paused";
const PAUSE_LABEL = "Pause background video";
const PLAY_LABEL = "Play background video";

/**
 * Bind pause/play for decorative looping header videos.
 */
export function initHeaderVideoPause(): void {
	const toggle = document.querySelector<HTMLButtonElement>("[data-header-video-toggle]");
	const videos = Array.from(document.querySelectorAll<HTMLVideoElement>("video.header-video"));

	if (!toggle || videos.length === 0) {
		toggle?.remove();
		return;
	}

	if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
		videos.forEach((video) => video.pause());
		toggle.remove();
		return;
	}

	const setPaused = (paused: boolean): void => {
		videos.forEach((video) => {
			if (paused) {
				video.pause();
			} else {
				void video.play();
			}
		});

		toggle.textContent = paused ? PLAY_LABEL : PAUSE_LABEL;

		try {
			window.localStorage.setItem(STORAGE_KEY, paused ? "1" : "0");
		} catch {
			// Ignore private-mode / blocked storage.
		}
	};

	let stored = false;
	try {
		stored = window.localStorage.getItem(STORAGE_KEY) === "1";
	} catch {
		stored = false;
	}

	setPaused(stored);

	toggle.addEventListener("click", () => {
		const isPaused = videos.every((video) => video.paused);
		setPaused(!isPaused);
	});
}
