import $ from "jquery";
import "../sass/frontend.scss";

$(function () {
  // DOM ready

  // If a link has a dropdown, add sub menu toggle.
  $("nav ul li a:not(:only-child)").click(function (e) {
    // Remove "active-dropdown" class from other anchor elements
    $("nav ul li a").not(this).removeClass("active-dropdown");

    // Toggle the "active-dropdown" class on the clicked anchor element
    $(this).toggleClass("active-dropdown");

    // Toggle the visibility of the sibling dropdown
    const mediaQuery = window.matchMedia("(max-width: 64em)");

    // Check the screen size using the media query
    if (mediaQuery.matches) {
      // Mobile: Use slideToggle()
      $(this).siblings(".nav-dropdown").slideToggle();
    } else {
      // Desktop: Use toggle()
      $(this).siblings(".nav-dropdown").toggle();
    }

    // Close one dropdown when selecting another
    $(".nav-dropdown").not($(this).siblings()).hide();

    e.stopPropagation();
  });

  // Clicking away from dropdown will remove the dropdown class and active-dropdown class
  $("html").click(function () {
    $(".nav-dropdown").hide();
    $("nav ul li a:not(:only-child)").removeClass("active-dropdown");
  });

  // Toggle open and close nav styles on click
  $("#nav-toggle").click(function () {
    $("nav ul").slideToggle();
  });

  // Hamburger to X toggle
  $("#nav-toggle").on("click", function () {
    this.classList.toggle("active");
  });
});
