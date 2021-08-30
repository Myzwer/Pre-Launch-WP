<?php
/**
 * Functions and definitions
 * This file is pretty intimidating if you are new, and that's okay.
 * Most of this is already pre-configured for you.
 * There are comments throughout to explain how to do things, edit things, and what to remove if needed.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @since 1.0.0
 */


//*****************************************************
//***************** CSS / JS Load-in ******************
//*****************************************************

// So here's the deal, if you're new to WP, you can't just load in scripts and styles using a script tag or wp pitches a
// hissy fit and won't work. You have to do what's called enqueuing them.
// https://www.wpbeginner.com/wp-tutorials/how-to-properly-add-javascripts-and-styles-in-wordpress/
// Luckily I have already done that below, and since Webpack only outputs 2 files, we only gotta do it twice.
// BUT, if for some reason you need to add another style or script, do that here.

// JQUERY. If you don't need it delete it.
function include_jQuery() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'include_jQuery');


// Javascript
function scripts_loadin() {
    wp_enqueue_script( 'frontend', get_template_directory_uri() . '/assets/public/js/frontend.js');
}
add_action('wp_enqueue_scripts', 'scripts_loadin');


// Styles
function load_styles() {
    wp_enqueue_style( 'frontend', get_template_directory_uri() . '/assets/public/css/frontend.css');
}
add_action('wp_enqueue_scripts', 'load_styles');



//*****************************************************
//******************* M E N U S ***********************
//*****************************************************

// This is the code to include the navwalker. If you aren't going to use the menu you'll need to get rid of this line.
// If you are going to use the navwalker, leave it alone. She's sensitive.
require_once("nav_walker.php");


/*
 * So, in order for WP Admin to even know menus exist, we have to create them here.
 * This theme ships with the navbar and 2 footer columns.
 * If for some reason you need more than this, you can copy and paste one of the code blocks below and modify it.
 * https://www.wpbeginner.com/wp-themes/how-to-add-custom-navigation-menus-in-wordpress-3-0-themes/
*/

//*********** Navbar ***********
function register_my_menu() {
    register_nav_menu('header-menu', ( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );


//*********** Footer Col 1 ***********
function register_col_1() {
    register_nav_menu('footer-column-1', ( 'Footer Column 1' ));
}
add_action( 'init', 'register_col_1' );

//*********** Footer Col 2 ***********
function register_col_2() {
    register_nav_menu('footer-column-2', ( 'Footer Column 2' ));
}
add_action( 'init', 'register_col_2' );


