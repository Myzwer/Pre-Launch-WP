<?php

/**
 * Asset Loading Strategy
 * ======================
 *
 * This theme intentionally separates styling into two layers:
 *
 * 1) frontend.css / frontend.js
 *    - Core design system + runtime JS.
 *    - Tokens, utilities, components, site-wide UI patterns.
 *
 * 2) blocks.css
 *    - Gutenberg bridge layer.
 *    - Maps core block markup (.wp-block-*) to the design system.
 *
 * blocks.css is loaded:
 * - On the frontend (after wp-block-library + frontend.css), so theme styles can
 *   override core block defaults.
 * - In the block editor (scoped via .editor-styles-wrapper selectors inside
 *   blocks.css) for preview parity without styling wp-admin chrome.
 *
 * Versioning uses file modification times (filemtime) when available to reduce
 * caching issues during development and after deployments.
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 */

/**
 * Enqueue the theme’s compiled JS/CSS bundles.
 */
function prelaunch_enqueue_assets(): void
{
    $theme_version = wp_get_theme()->get('Version');

    // ----- JS bundle -----
    $js_rel_path = '/assets/public/js/frontend.js';
    $js_file = get_theme_file_path($js_rel_path);
    $js_ver = file_exists($js_file) ? (string) filemtime($js_file) : $theme_version;

    wp_enqueue_script(
        'prelaunch-frontend',
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
        'prelaunch-frontend',
        get_theme_file_uri($css_rel_path),
        [],
        $css_ver
    );
}
add_action('wp_enqueue_scripts', 'prelaunch_enqueue_assets');

/**
 * Enqueue Gutenberg bridge stylesheet (frontend).
 *
 * Responsibility:
 * - Maps core block markup (.wp-block-*) to theme styles.
 *
 * Load Order Requirement:
 * - Must load after wp-block-library so theme styles override core block styles.
 * - Must load after prelaunch-frontend so design tokens/variables are available.
 *
 * Policy:
 * - Loaded globally. If block markup exists anywhere, it should render correctly.
 */
function prelaunch_enqueue_blocks_bridge_css(): void
{
    $theme_version = wp_get_theme()->get('Version');

    $rel_path = '/assets/public/css/blocks.css';
    $file = get_theme_file_path($rel_path);
    $ver = file_exists($file) ? (string) filemtime($file) : $theme_version;

    wp_enqueue_style(
        'prelaunch-blocks',
        get_theme_file_uri($rel_path),
        [
            'wp-block-library',
            'prelaunch-frontend',
        ],
        $ver
    );
}
add_action('wp_enqueue_scripts', 'prelaunch_enqueue_blocks_bridge_css');

/**
 * Enqueue Font Awesome (self-hosted).
 *
 * This theme uses <i> tag classnames for icons (no SVG/JS runtime). To avoid
 * Font Awesome Kit “late loading,” FA CSS + webfonts are shipped locally.
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
function prelaunch_enqueue_font_awesome(): void
{
    $theme_version = wp_get_theme()->get('Version');

    $rel_css = '/assets/public/vendor/fontawesome/css/all.min.css';
    $path = get_theme_file_path($rel_css);
    $ver = file_exists($path) ? (string) filemtime($path) : $theme_version;

    wp_enqueue_style(
        'prelaunch-font-awesome',
        get_theme_file_uri($rel_css),
        [],
        $ver
    );
}
// Load FA early so icons/styles are available as soon as possible.
add_action('wp_enqueue_scripts', 'prelaunch_enqueue_font_awesome', 5);

/**
 * Block editor-only behavior controls.
 *
 * editor-block-styles.js adjusts the available style variations for core blocks
 * (e.g., removes core Button defaults like "Fill" and "Outline") to keep authoring
 * options aligned with the theme's design system.
 */
add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'prelaunch-editor-block-styles',
        get_theme_file_uri('/assets/admin/editor-block-styles.js'),
        ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
        null,
        true
    );
});

/**
 * Enqueue Gutenberg bridge stylesheet (block editor).
 *
 * Purpose:
 * - Align block editor preview with frontend rendering.
 *
 * Notes:
 * - Loads only inside the block editor.
 * - Does not enqueue the full frontend stylesheet to avoid unintended wp-admin UI
 *   side effects.
 * - blocks.css selectors include .editor-styles-wrapper to scope styling to the
 *   editor canvas.
 */
function prelaunch_enqueue_blocks_editor_assets(): void
{
    $theme_version = wp_get_theme()->get('Version');

    $rel_path = '/assets/public/css/blocks.css';
    $file = get_theme_file_path($rel_path);
    $ver = file_exists($file) ? (string) filemtime($file) : $theme_version;

    wp_enqueue_style(
        'prelaunch-blocks-editor',
        get_theme_file_uri($rel_path),
        [],
        $ver
    );
}
add_action('enqueue_block_editor_assets', 'prelaunch_enqueue_blocks_editor_assets');
