<?php
/**
 * Quick Functions
 *
 * This file contains a quick function to alphabetize page templates in a WordPress theme.
 *
 * Usage: Include this file in functions.php to apply the alphabetization filter to page templates.
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */

function alphabetize_page_templates($templates)
{
    asort($templates);
    return $templates;
}

add_filter('theme_page_templates', 'alphabetize_page_templates');
