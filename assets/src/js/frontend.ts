import $ from "jquery";
import "../css/tailwind.css";
import "../css/frontend.css";
import "./accordion";

$(() => {
  const $navLinksWithDropdown = $("nav ul li a:not(:only-child)");
  const $navDropdowns = $(".nav-dropdown");
  const $navToggle = $("#nav-toggle");
  const $navUl = $("nav ul");

  // If a link has a dropdown, add sub menu toggle.
  $navLinksWithDropdown.on("click", function (this: HTMLElement, e) {
    e.preventDefault();
    e.stopPropagation();

    // Remove "active-dropdown" class from other anchor elements
    $("nav ul li a").not(this).removeClass("active-dropdown");

    // Toggle the "active-dropdown" class on the clicked anchor element
    $(this).toggleClass("active-dropdown");

    // Toggle the visibility of the sibling dropdown
    const mediaQuery = window.matchMedia("(max-width: 64em)");

    if (mediaQuery.matches) {
      $(this).siblings(".nav-dropdown").slideToggle();
    } else {
      $(this).siblings(".nav-dropdown").toggle();
    }

    // Close one dropdown when selecting another
    $navDropdowns.not($(this).siblings()).hide();
  });

  // Clicking away from dropdown will remove the dropdown class and active-dropdown class
  $("html").on("click", () => {
    $navDropdowns.hide();
    $navLinksWithDropdown.removeClass("active-dropdown");
  });

  // Toggle open/close nav styles AND hamburger->X toggle
  $navToggle.on("click", function (this: HTMLElement) {
    $navUl.slideToggle();
    this.classList.toggle("active");
  });
});
