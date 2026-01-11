import $ from "jquery";

$(document).ready(() => {
  $("details").on(
    "toggle",
    function (this: HTMLDetailsElement, _event: Event) {
      const detailsElement = $(this).find(".tab-details");

      if (this.open) {
        detailsElement.slideDown();
      } else {
        detailsElement.slideUp();
      }
    }
  );
});
