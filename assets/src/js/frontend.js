import "../sass/frontend.scss";

jQuery(document).ready(function () {
  jQuery(".borger-menu").click(function () {
    jQuery(this).toggleClass("open");
  });
});
