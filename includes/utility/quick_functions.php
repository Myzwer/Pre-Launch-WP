<?php

/**
 * Quick functions
 *
 * Small, optional quality-of-life helpers that don’t belong in a larger feature module.
 * Keep this file lean—if a helper grows beyond a few lines or becomes site-specific,
 * move it into a dedicated file.
 *
 * Current:
 * - Register core theme supports (e.g., title-tag for SEO plugin compatibility).
 * - Alphabetize page templates in the Page Attributes template dropdown.
 * - Display a non-production environment badge in the admin bar.
 * - Disable comments site-wide (UI + front end + admin cleanup).
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 * @link https://developer.wordpress.org/reference/hooks/theme_page_templates/
 * @link https://developer.wordpress.org/reference/functions/wp_get_environment_type/
 * @link https://developer.wordpress.org/reference/functions/remove_post_type_support/
 * @link https://developer.wordpress.org/reference/hooks/comments_open/
 * @link https://developer.wordpress.org/reference/hooks/pings_open/
 */

declare(strict_types=1);

/**
 * Register core theme supports.
 *
 * Adds foundational WordPress features required for predictable behavior
 * across the theme and plugin ecosystem.
 *
 * Currently registers:
 * - title-tag: Allows WordPress (and SEO plugins like The SEO Framework)
 *   to control the <title> element dynamically. Without this support,
 *   SEO plugins cannot reliably filter or modify document titles.
 */
function prelaunch_theme_setup(): void
{
    add_theme_support('title-tag');
    load_theme_textdomain('prelaunch-wp', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'prelaunch_theme_setup');

/**
 * Alphabetize page templates in the editor dropdown.
 *
 * @param array<string,string> $templates Template file => label.
 * @return array<string,string>
 */
function prelaunch_alphabetize_page_templates(array $templates): array
{
    asort($templates);
    return $templates;
}
add_filter('theme_page_templates', 'prelaunch_alphabetize_page_templates');

/**
 * Add an environment indicator to the admin bar on non-production environments.
 *
 * Helps prevent accidental edits on the wrong site when working across
 * development, staging, and production.
 */
function prelaunch_admin_bar_environment_badge(): void
{
    // Only show to admins and only outside of production.
    if (
        ! is_admin_bar_showing() ||
        ! current_user_can('manage_options') ||
        wp_get_environment_type() === 'production'
    ) {
        return;
    }

    $env = strtoupper(wp_get_environment_type());

    global $wp_admin_bar;

    $wp_admin_bar->add_node([
        'id' => 'prelaunch-env-badge',
        'title' => esc_html($env),
        'meta' => [
            // Inline styles keep this self-contained and avoid extra CSS.
            'style' => 'background:#d63638;color:#fff;padding:2px 8px;border-radius:3px;font-weight:600;',
        ],
    ]);
}
add_action('admin_bar_menu', 'prelaunch_admin_bar_environment_badge', 100);

/**
 * Disable comments site-wide.
 *
 * This theme defaults comments off (common for brochure/ACF-driven sites).
 * If a project needs comments later, remove this block or gate it behind a constant.
 *
 * What this does:
 * - Removes comment + trackback support from post types (editor/admin UI)
 * - Forces comments/pings closed on the front end
 * - Hides comment admin UI (menus, metabox, admin bar)
 * - Redirects comment management screens to the dashboard
 *
 * @link https://developer.wordpress.org/reference/functions/remove_post_type_support/
 * @link https://developer.wordpress.org/reference/hooks/comments_open/
 * @link https://developer.wordpress.org/reference/hooks/pings_open/
 * @link https://developer.wordpress.org/reference/hooks/admin_menu/
 */
function prelaunch_disable_comments_setup(): void
{
    // Remove comment support from all registered post types that expose it.
    foreach (get_post_types([], 'names') as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('init', 'prelaunch_disable_comments_setup', 100);

/**
 * Always close comments and pings on the front end.
 *
 * This prevents bots from submitting comments even if something re-enables UI.
 */
function prelaunch_disable_comments_status(): bool
{
    return false;
}
add_filter('comments_open', 'prelaunch_disable_comments_status', 20);
add_filter('pings_open', 'prelaunch_disable_comments_status', 20);

/**
 * Hide existing comments from appearing in templates that call comments_template().
 */
add_filter('comments_array', static fn (array $comments): array => [], 10, 2);

/**
 * Remove comment UI entry points in the WordPress admin.
 */
function prelaunch_disable_comments_admin_ui(): void
{
    // Remove the Comments menu item.
    remove_menu_page('edit-comments.php');

    // Remove the Discussion metabox from post/page edit screens.
    remove_meta_box('commentstatusdiv', 'post', 'normal');
    remove_meta_box('commentsdiv', 'post', 'normal');
    remove_meta_box('commentstatusdiv', 'page', 'normal');
    remove_meta_box('commentsdiv', 'page', 'normal');

    // If you have custom post types that add these metaboxes, the init() removal above
    // generally prevents them, but plugins can re-add. Keeping these removals is cheap.
}
add_action('admin_menu', 'prelaunch_disable_comments_admin_ui');

/**
 * Remove the Comments item from the admin bar.
 */
function prelaunch_disable_comments_admin_bar(): void
{
    if (! is_admin_bar_showing()) {
        return;
    }

    global $wp_admin_bar;
    $wp_admin_bar->remove_node('comments');
}
add_action('admin_bar_menu', 'prelaunch_disable_comments_admin_bar', 999);

/**
 * Redirect any direct access to comment management screens back to the dashboard.
 */
function prelaunch_disable_comments_admin_redirect(): void
{
    global $pagenow;

    if ($pagenow === 'edit-comments.php' || $pagenow === 'comment.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'prelaunch_disable_comments_admin_redirect');
