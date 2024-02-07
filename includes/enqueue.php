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
    wp_enqueue_script('churchcenter-modal', 'https://js.churchcenter.com/modal/v1', array(), null, true);
}

add_action('wp_enqueue_scripts', 'churchcenter_script');


// Styles Load In
function load_styles()
{
    wp_enqueue_style('frontend', get_template_directory_uri() . '/assets/public/css/frontend.css');
}

add_action('wp_enqueue_scripts', 'load_styles');
