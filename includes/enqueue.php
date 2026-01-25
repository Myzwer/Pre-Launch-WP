<?php

/**
 * Enqueue
 *
 * This file contains the functions necessary to enqueue scripts and styles onto the site in the "Wordpress" way.
 *
 * Usage: Include this file in functions.php to load in scripts and styles into the site.
 * If you need to link an ENTIRE NEW file, that can be done here.
 * Additional partials should be linked into frontend js/css files, not given a new file.
 *
 * @link: https://www.wpbeginner.com/wp-tutorials/how-to-properly-add-javascripts-and-styles-in-wordpress/
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */

// Javascript Load In
// Jquery is being loaded into this file via webpack
function scripts_loadin()
{
    wp_enqueue_script('frontend', get_template_directory_uri() . '/assets/public/js/frontend.js');
}

add_action('wp_enqueue_scripts', 'scripts_loadin');

function churchcenter_script()
{
    wp_enqueue_script('churchcenter-modal', 'https://js.churchcenter.com/modal/v1', [], null, true);
}

add_action('wp_enqueue_scripts', 'churchcenter_script');

// Styles Load In
function load_styles()
{
    wp_enqueue_style('frontend', get_template_directory_uri() . '/assets/public/css/frontend.css');
}

add_action('wp_enqueue_scripts', 'load_styles');

/**
 * Font Awesome (global icon support)
 *
 * Uses Font Awesome Kit for:
 * - Navbar carets
 * - Menu item icons (via nav_walker.php)
 *
 * README:FONT_AWESOME
 * - Swap kit URL if needed
 * - If a client requires CSP compliance or no external scripts,
 *   replace this with a locally hosted subset or SVG sprite.
 */
function enqueue_font_awesome()
{
    wp_enqueue_script(
        'font-awesome',
        'https://kit.fontawesome.com/fbeae66fcb.js',
        [],
        null,
        false // load in <head> (icons may be needed during first paint)
    );
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');
