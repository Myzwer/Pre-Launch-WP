<?php

/**
 * Asset loading
 *
 * Enqueues the theme’s compiled frontend assets (CSS/JS), plus optional vendor
 * assets that are shipped with the theme (e.g., Font Awesome).
 *
 * This theme assumes a single compiled bundle for CSS and JS:
 * - /assets/public/css/frontend.css
 * - /assets/public/js/frontend.js
 *
 * Versions use file modification times (filemtime) when available to reduce
 * caching issues during development and after deployments.
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 */

/**
 * Enqueue the theme’s compiled JS/CSS bundles.
 */
function windpeak_enqueue_assets(): void
{
    $theme_version = wp_get_theme()->get('Version');

    // ----- JS bundle -----
    $js_rel_path = '/assets/public/js/frontend.js';
    $js_file = get_theme_file_path($js_rel_path);
    $js_ver = file_exists($js_file) ? (string) filemtime($js_file) : $theme_version;

    wp_enqueue_script(
        'windpeak-frontend',
        get_theme_file_uri($js_rel_path),
        [],
        $js_ver,
        true // Load in footer for better performance / less render blocking.
    );

    // ----- CSS bundle -----
    $css_rel_path = '/assets/public/css/frontend.css';
    $css_file = get_theme_file_path($css_rel_path);
    $css_ver = file_exists($css_file) ? (string) filemtime($css_file) : $theme_version;

    wp_enqueue_style(
        'windpeak-frontend',
        get_theme_file_uri($css_rel_path),
        [],
        $css_ver
    );
}
add_action('wp_enqueue_scripts', 'windpeak_enqueue_assets');

/**
 * Enqueue Font Awesome (self-hosted).
 *
 * This theme uses <i> tag classnames for icons (no SVG/JS runtime). To avoid
 * Font Awesome Kit “late loading,” we ship the FA CSS + webfonts locally.
 *
 * Required output structure (relative paths matter):
 * - /assets/public/vendor/fontawesome/css/all.min.css
 * - /assets/public/vendor/fontawesome/webfonts/...
 *
 * In this project, Font Awesome is treated as a static vendor asset:
 * it is copied 1:1 during the build step (not bundled into frontend.css).
 *
 * @link https://fontawesome.com/download
 * @link https://fontawesome.com/docs/web/setup/host-yourself
 */
function windpeak_enqueue_font_awesome(): void
{
    $theme_version = wp_get_theme()->get('Version');

    $rel_css = '/assets/public/vendor/fontawesome/css/all.min.css';
    $path = get_theme_file_path($rel_css);
    $ver = file_exists($path) ? (string) filemtime($path) : $theme_version;

    wp_enqueue_style(
        'windpeak-font-awesome',
        get_theme_file_uri($rel_css),
        [],
        $ver
    );
}
// Load FA early so icons/styles are available as soon as possible.
add_action('wp_enqueue_scripts', 'windpeak_enqueue_font_awesome', 5);

add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'prelaunch-editor-block-styles',
        get_theme_file_uri('/assets/admin/editor-block-styles.js'),
        ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
        null,
        true
    );
});
