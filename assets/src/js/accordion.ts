import $ from "jquery";

$(document).ready(() => {
	const SPEED = 200;

	$(".faq-content").on("click", "summary", function (e) {
		e.preventDefault();

		const $details = $(this).closest("details");
		const $panel = $details.children(".tab-details");

		if ($panel.length === 0) return;

		// Prevent animation queue buildup
		$panel.stop(true, true);

		if ($details.prop("open")) {
			// CLOSE: animate first, then remove open
			$panel.slideUp(SPEED, () => {
				$details.prop("open", false);
			});
		} else {
			// OPEN: set open first so content can render, then animate
			$details.prop("open", true);
			$panel.hide().slideDown(SPEED);
		}
	});
});
