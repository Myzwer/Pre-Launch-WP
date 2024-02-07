<?php
/**
 * ACF
 *
 * This file contains a quick function to allow the options page to display in WP Admin
 *
 * Usage: Include this file in functions.php to see the options page in ACF.
 * No clue why this doesn't ship turned on by default but whatever.
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */

// Add the options page to admin
// https://www.advancedcustomfields.com/resources/options-page/

if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}
