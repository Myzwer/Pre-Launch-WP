<?php

/**
 * Functions and definitions
 *
 * The primary functions file for the theme. It includes various modular files
 * responsible for handling script and style enqueue, Advanced Custom Fields (ACF) configurations,
 * quick utility functions, WordPress menu setups, post-related functions and pagination,
 * custom post type registrations, and shortcodes.
 *
 *
 * Usage: Wordpress defaults to use this file.
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */

// Include Scripts and Styles
require_once get_template_directory() . '/includes/enqueue.php';

// Include ACF Functions
require_once get_template_directory() . '/includes/acf.php';

// Include Quick Functions
require_once get_template_directory() . '/includes/quick_functions.php';

// Include WP Menus (Header and Footer)
require_once get_template_directory() . '/includes/menus.php';

// Include Posts (Post Functions + Pagination)
require_once get_template_directory() . '/includes/wpposts.php';

// Include Custom Post Types
require_once get_template_directory() . '/includes/custom_post_types.php';

// Include Shortcodes
require_once get_template_directory() . '/includes/shortcodes.php';

// Include SEO
require_once get_template_directory() . '/includes/seo.php';

// Include Editor Tools (TinyMCE)
require_once get_template_directory() . '/includes/editor_tools.php';

// Include Admin Cleanup
require_once get_template_directory() . '/includes/admin_editor_cleanup.php';

// Include Admin Dashboard Cleanup
require_once get_template_directory() . '/includes/admin_dashboard.php';

// Include Token Widget to Admin Dashboard
require_once get_template_directory() . '/includes/admin_tokens_widget.php';
