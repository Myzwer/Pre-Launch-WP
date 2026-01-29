<?php

/**
 * Theme bootstrap
 *
 * Loads modular theme files from /includes. This file will stay lean and act as an
 * include map + load-order reference for theme functionality.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://developer.wordpress.org/reference/functions/get_theme_file_path/
 */

/* Posts / content system (blog now, CPT-ready utilities later) */
require_once get_theme_file_path('includes/posts/setup.php');
require_once get_theme_file_path('includes/posts/content.php');
require_once get_theme_file_path('includes/posts/queries.php');
require_once get_theme_file_path('includes/posts/template-tags.php');

/* WordPress theme features (menus, assets, shortcodes, etc.) */
require_once get_theme_file_path('includes/wordpress/enqueue.php');
require_once get_theme_file_path('includes/wordpress/menus.php');
require_once get_theme_file_path('includes/wordpress/shortcodes.php');

/* Blog legacy helpers (to be removed once migrated into /includes/posts/*) */
require_once get_theme_file_path('includes/posts/wpposts.php');

/* Plugins / integrations */
require_once get_theme_file_path('includes/plugins/acf.php');
require_once get_theme_file_path('includes/plugins/seo.php');

/* Utility functions */
require_once get_theme_file_path('includes/utility/quick_functions.php');

/* Admin */
require_once get_theme_file_path('includes/admin/editor_tools.php');
require_once get_theme_file_path('includes/admin/admin_editor_cleanup.php');
require_once get_theme_file_path('includes/admin/admin_dashboard.php');
require_once get_theme_file_path('includes/admin/admin_tokens_widget.php');
