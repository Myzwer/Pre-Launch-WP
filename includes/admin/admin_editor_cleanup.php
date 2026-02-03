<?php

/**
 * Admin Editor Cleanup (ACF-First Workflow)
 *
 * Enforces an ACF-first editing experience for selected post types (pages + CPTs),
 * while leaving WordPress internal post types (wp_*) untouched.
 *
 * Behavior (for ACF-driven types):
 * - Disable Gutenberg
 * - Remove the classic content editor UI
 * - Force ACF field groups to render after the title
 * - Apply ACF “seamless” styling
 * - Display a small admin note
 * - Enqueue admin-only CSS for ACF UI improvements
 */

defined('ABSPATH') || exit;

/**
 * Post types that should be ACF-driven (no Gutenberg + no content editor).
 *
 * Add CPT slugs here (e.g. 'agents', 'staff', 'sermons').
 */
function wpk_acf_driven_post_types(): array
{
    return [
        'page',
        // 'agents',
        // 'staff',
        // 'sermons',
    ];
}

/**
 * True when we're on a post edit screen for an ACF-driven post type.
 */
function wpk_is_acf_driven_edit_screen(): bool
{
    if (! is_admin()) {
        return false;
    }

    if (! function_exists('get_current_screen')) {
        return false;
    }

    $screen = get_current_screen();
    if (! $screen || $screen->base !== 'post') {
        return false;
    }

    $post_type = (string) $screen->post_type;

    // Only apply to explicitly ACF-driven types (and never to internal wp_* types).
    if (str_starts_with($post_type, 'wp_')) {
        return false;
    }

    return in_array($post_type, wpk_acf_driven_post_types(), true);
}

/**
 * Disable the Block Editor (Gutenberg) for ACF-driven post types only.
 *
 * Important: do NOT disable for wp_* internal types.
 */
function wpk_disable_gutenberg_for_acf_types(bool $use_block_editor, string $post_type): bool
{
    if (str_starts_with($post_type, 'wp_')) {
        return $use_block_editor;
    }

    if (in_array($post_type, wpk_acf_driven_post_types(), true)) {
        return false;
    }

    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'wpk_disable_gutenberg_for_acf_types', 10, 2);

/**
 * Remove the classic content editor support for ACF-driven post types only.
 *
 * Important: do NOT iterate all post types and remove editor support globally.
 */
function wpk_remove_editor_for_acf_types(): void
{
    foreach (wpk_acf_driven_post_types() as $post_type) {
        // Only remove editor support if the post type exists.
        if (post_type_exists($post_type)) {
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
    if (! wpk_is_acf_driven_edit_screen()) {
        return $field_group;
    }

    $field_group['position'] = 'acf_after_title';
    return $field_group;
}
add_filter('acf/get_field_group', 'wpk_acf_position_field_groups_after_title', 20);

/**
 * Apply "seamless" styling to ACF field groups.
 */
function wpk_acf_use_seamless_field_group_style(array $field_group): array
{
    if (! wpk_is_acf_driven_edit_screen()) {
        return $field_group;
    }

    $field_group['style'] = 'seamless';
    return $field_group;
}
add_filter('acf/get_field_group', 'wpk_acf_use_seamless_field_group_style', 20);

/**
 * Display an admin note above ACF fields on ACF-driven edit screens.
 */
function wpk_acf_editor_admin_note(): void
{
    if (! wpk_is_acf_driven_edit_screen()) {
        return;
    }

    echo '<div class="inline notice notice-info" style="margin: 10px 0;">
		<p><strong>Page Content:</strong> Build this page using the sections below.</p>
	</div>';
}
add_action('edit_form_after_title', 'wpk_acf_editor_admin_note');

/**
 * Enqueue admin-only CSS for ACF UI improvements.
 */
function wpk_admin_enqueue_acf_admin_css(): void
{
    if (! wpk_is_acf_driven_edit_screen()) {
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
 * Flexible Content guidance notes (minimal).
 *
 * - Header field only (header_select): remind it should be limited to 1.
 */
function wpk_acf_flexible_content_notes(array $field): void
{
    if (! wpk_is_acf_driven_edit_screen()) {
        return;
    }

    if (($field['type'] ?? '') !== 'flexible_content') {
        return;
    }

    if (($field['name'] ?? '') === 'header_select') {
        echo '<div style="margin: 0 0 10px; padding: 10px 12px; border: 1px solid #dcdcde; border-left: 4px solid #dba617; background: #fff;">
			<strong>Header:</strong> This area is intended to contain only one header section.
		</div>';
    }
}
add_action('acf/render_field/type=flexible_content', 'wpk_acf_flexible_content_notes', 5);
