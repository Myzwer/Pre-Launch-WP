import $ from "jquery";

$(document).ready(function($) {
  $("details").on("toggle", function() {
    const detailsElement = $(this).find(".tab-details");

    if (this.open) {
      detailsElement.slideDown();
    } else {
      detailsElement.slideUp();
    }
  });
});
