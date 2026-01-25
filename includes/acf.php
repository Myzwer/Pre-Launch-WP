<?php

/**
 * ACF Globals Options Page
 *
 * Registers a global settings page in the WordPress admin using
 * Advanced Custom Fields. Intended for site-wide values such as
 * brand settings, global toggles, and reusable content.
 *
 * @link https://www.advancedcustomfields.com/resources/options-page/
 */

declare(strict_types=1);

/**
 * Register the ACF "Globals" options page.
 *
 * Hooked into `acf/init` to ensure ACF is fully loaded before use.
 */
add_action('acf/init', static function (): void {
    // Bail early if ACF is not active or available.
    if (! function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => 'Globals',
        'menu_title' => 'Globals',
        'menu_slug' => 'acf-globals',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-site', // Globe icon
        'redirect' => false,
    ]);
});
