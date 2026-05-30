import $ from "jquery";

$(document).ready(() => {
	const SPEED = 200;

	$("[data-accordion]").each(function () {
		const $accordion = $(this);

		$accordion.addClass("is-animated");

		$accordion.find(".accordion__item").each(function () {
			const $details = $(this);
			const $panel = $details.children(".accordion__panel");

			if (!$details.prop("open")) {
				$panel.hide();
			}
		});
	});

	$("[data-accordion]").on("click", ".accordion__summary", function (event) {
		event.preventDefault();

		const $summary = $(this);
		const $details = $summary.closest(".accordion__item");
		const $panel = $details.children(".accordion__panel");

		if ($panel.length === 0) {
			return;
		}

		$panel.stop(true, true);

		if ($details.prop("open")) {
			$panel.slideUp(SPEED, () => {
				$details.prop("open", false);
			});

			return;
		}

		$details.prop("open", true);
		$panel.hide().slideDown(SPEED);
	});
});
