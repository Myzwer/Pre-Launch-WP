<?php

/**
 * Admin Editor Cleanup (ACF-First Workflow)
 *
 * This file enforces an ACF-first editing experience for this starter theme.
 *
 * Behavior:
 * - Disable Gutenberg for all post types except `post`
 * - Remove the classic content editor UI for all post types except `post`
 * - Force ACF field groups to render directly after the title
 * - Apply ACF “seamless” styling to reduce meta-box chrome
 * - Display a small admin note clarifying where page content is built
 * - Add lightweight guidance notes for Flexible Content usage
 * - Enqueue admin-only CSS for ACF UI improvements
 */

defined('ABSPATH') || exit;

/**
 * Disable the Block Editor (Gutenberg) for all post types except `post`.
 */
function wpk_disable_gutenberg_for_acf_types(bool $use_block_editor, string $post_type): bool
{
    $allow_gutenberg = [
        'post',
        // 'example_cpt',
    ];

    if (in_array($post_type, $allow_gutenberg, true)) {
        return $use_block_editor;
    }

    return false;
}
add_filter('use_block_editor_for_post_type', 'wpk_disable_gutenberg_for_acf_types', 10, 2);

/**
 * Remove the classic content editor support for ACF-driven post types.
 *
 * This hides the large editor panel on Pages and CPTs so users aren’t tempted
 * to type content into an area that is not used.
 */
function wpk_remove_editor_for_acf_types(): void
{
    $allow_editor = [
        'post',
        // 'example_cpt',
    ];

    $post_types = get_post_types([], 'names');

    foreach ($post_types as $post_type) {
        if (in_array($post_type, ['attachment', 'revision', 'nav_menu_item'], true)) {
            continue;
        }

        if (!in_array($post_type, $allow_editor, true)) {
            remove_post_type_support($post_type, 'editor');
        }
    }
}
add_action('init', 'wpk_remove_editor_for_acf_types', 20);

/**
 * Force ACF field groups to appear directly after the title.
 */
function wpk_acf_position_field_groups_after_title(array $field_group): array
{
    $field_group['position'] = 'acf_after_title';
    return $field_group;
}
add_filter('acf/get_field_group', 'wpk_acf_position_field_groups_after_title', 20);

/**
 * Apply "seamless" styling to ACF field groups.
 */
function wpk_acf_use_seamless_field_group_style(array $field_group): array
{
    $field_group['style'] = 'seamless';
    return $field_group;
}
add_filter('acf/get_field_group', 'wpk_acf_use_seamless_field_group_style', 20);

/**
 * Display an admin note above ACF fields on ACF-driven edit screens.
 */
function wpk_acf_editor_admin_note(): void
{
    $screen = get_current_screen();

    if (!$screen || $screen->base !== 'post') {
        return;
    }

    if ($screen->post_type === 'post') {
        return;
    }

    echo '<div class="inline notice notice-info" style="margin: 10px 0;">
		<p><strong>Page Content:</strong> Build this page using the sections below.</p>
	</div>';
}
add_action('edit_form_after_title', 'wpk_acf_editor_admin_note');

/**
 * Enqueue admin-only CSS for ACF UI improvements.
 *
 * This is intentionally not bundled with the frontend build pipeline.
 */
function wpk_admin_enqueue_acf_admin_css(): void
{
    if (!is_admin()) {
        return;
    }

    wp_enqueue_style(
        'wpk-acf-admin',
        get_template_directory_uri() . '/assets/admin/acf-admin.css',
        [],
        '0.1.0'
    );
}
add_action('admin_enqueue_scripts', 'wpk_admin_enqueue_acf_admin_css');

/**
 * Flexible Content guidance notes (ACF-only screens).
 *
 * - All Flexible Content fields: remind that section order matters.
 * - Header field only (header_select): remind it should be limited to 1.
 *
 * This is guidance, not enforcement. It keeps the starter theme flexible
 * while preventing common client mistakes.
 *
 * Field names used here:
 * - header_select
 * - body_sections
 */
/**
 * Flexible Content guidance notes (minimal).
 *
 * - Header field only (header_select): remind it should be limited to 1.
 *
 * This is guidance, not enforcement.
 */
function wpk_acf_flexible_content_notes(array $field): void
{
    if (($field['type'] ?? '') !== 'flexible_content') {
        return;
    }

    if (($field['name'] ?? '') === 'header_select') {
        echo '<div style="margin: 0 0 10px; padding: 10px 12px; border: 1px solid #dcdcde; border-left: 4px solid #dba617; background: #fff;">
			<strong>Header:</strong> This area is intended to contain only one header section.
		</div>';
    }
}
