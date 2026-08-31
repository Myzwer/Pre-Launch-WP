<?php

/**
 * Admin Editor Tools (TinyMCE)
 *
 * Adds a TinyMCE toolbar button for ACF WYSIWYG fields (classic editor engine).
 * This is a theme-level QoL enhancement: it ONLY inserts shortcodes; it does not
 * change frontend rendering logic.
 */

defined('ABSPATH') || exit;

/**
 * TinyMCE: load external plugin JS file.
 *
 * @param array $plugins Key-value map of TinyMCE plugins => URL.
 * @return array
 */
function prelaunch_mce_register_button_plugin(array $plugins): array
{
    // Only register in admin where TinyMCE runs.
    if (!is_admin()) {
        return $plugins;
    }

    $plugins['prelaunch_btn'] = get_template_directory_uri() . '/assets/admin/tinymce-btn.js';
    return $plugins;
}
add_filter('mce_external_plugins', 'prelaunch_mce_register_button_plugin');

/**
 * TinyMCE: add our button to the first toolbar row (same row as bold/italic/etc).
 *
 * @param array $buttons
 * @return array
 */
function prelaunch_mce_add_toolbar_button(array $buttons): array
{
    // Avoid duplicates.
    if (!in_array('prelaunch_btn', $buttons, true)) {
        $buttons[] = 'prelaunch_btn';
    }

    return $buttons;
}
add_filter('mce_buttons', 'prelaunch_mce_add_toolbar_button');

/**
 * ACF: ensure our button appears in ALL ACF WYSIWYG toolbars.
 *
 * ACF defines toolbars as arrays like:
 * $toolbars['Full'][1] = [ 'formatselect', 'bold', ... ]
 *
 * @param array $toolbars
 * @return array
 */
function prelaunch_acf_add_button_to_all_wysiwyg_toolbars(array $toolbars): array
{
    foreach ($toolbars as $toolbar_name => $rows) {
        // ACF rows are typically indexed starting at 1
        if (!isset($toolbars[$toolbar_name][1]) || !is_array($toolbars[$toolbar_name][1])) {
            continue;
        }

        if (!in_array('prelaunch_btn', $toolbars[$toolbar_name][1], true)) {
            $toolbars[$toolbar_name][1][] = 'prelaunch_btn';
        }
    }

    return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'prelaunch_acf_add_button_to_all_wysiwyg_toolbars');

/**
 * Admin CSS: style the TinyMCE button + (later) the modal UI.
 *
 * For this first pass, we load this anywhere in wp-admin. If you want to scope
 * later, we can restrict to post edit screens and ACF options pages.
 */
function prelaunch_admin_enqueue_editor_tools_css(): void
{
    if (!is_admin()) {
        return;
    }

    wp_enqueue_style(
        'prelaunch-tinymce-btn',
        get_template_directory_uri() . '/assets/admin/tinymce-btn.css',
        [],
        '0.1.0'
    );
}
add_action('admin_enqueue_scripts', 'prelaunch_admin_enqueue_editor_tools_css');
