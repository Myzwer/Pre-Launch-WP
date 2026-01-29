<?php

/**
 * Admin Dashboard (Starter Defaults)
 *
 * This file defines the default WordPress dashboard experience for this starter theme.
 *
 * Behavior:
 * - Removes common default dashboard widgets that create noise/confusion for clients
 * - Removes the Welcome panel
 * - Adds a single "Site Overview" widget with quick links and basic environment info
 * - Shows a small whimsical line that rotates on refresh (pure PHP, no dependencies)
 *
 * Goal:
 * - Reduce client friction and support calls ("where do I click?" / "am I on the right site?")
 * - Keep the dashboard calm, predictable, and low-maintenance across many sites
 */

defined('ABSPATH') || exit;

/**
 * Remove the Welcome panel.
 */
function wpk_dashboard_remove_welcome_panel(): void
{
    remove_action('welcome_panel', 'wp_welcome_panel');
}
add_action('admin_init', 'wpk_dashboard_remove_welcome_panel');

/**
 * Remove default dashboard widgets that are typically not useful in an ACF-first site.
 */
function wpk_dashboard_remove_default_widgets(): void
{
    remove_meta_box('dashboard_primary', 'dashboard', 'side');       // WordPress Events & News / feed (varies)
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');     // Secondary feed box
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');   // Quick Draft
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');    // Activity
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Site Health Status
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // At a Glance (optional)

    // Safe: remove_meta_box is a no-op if a box ID doesn't exist.
}
add_action('wp_dashboard_setup', 'wpk_dashboard_remove_default_widgets', 20);

/**
 * Add the "Site Overview" dashboard widget.
 */
function wpk_dashboard_add_site_overview_widget(): void
{
    wp_add_dashboard_widget(
        'wpk_site_overview',
        'Site Overview',
        'wpk_dashboard_render_site_overview_widget'
    );
}
add_action('wp_dashboard_setup', 'wpk_dashboard_add_site_overview_widget', 30);

/**
 * Get the current environment label (Local / Staging / Production).
 *
 * Uses WordPress core environment type when available; falls back conservatively.
 */
function wpk_get_environment_label(): string
{
    // WordPress core (WP 5.5+): returns 'local', 'development', 'staging', or 'production'
    if (function_exists('wp_get_environment_type')) {
        $type = wp_get_environment_type();
    } elseif (defined('WP_ENVIRONMENT_TYPE')) {
        $type = (string) WP_ENVIRONMENT_TYPE;
    } else {
        // Fallback: treat WP_DEBUG as "Development", otherwise "Production"
        $type = (defined('WP_DEBUG') && WP_DEBUG) ? 'development' : 'production';
    }

    $map = [
        'local' => 'Local',
        'development' => 'Development',
        'staging' => 'Staging',
        'production' => 'Production',
    ];

    return $map[$type] ?? ucfirst((string) $type);
}

/**
 * Try to locate the ACF Options page whose label/title is "Globals".
 *
 * Returns a wp-admin URL if found, otherwise null.
 */
function wpk_get_globals_options_url(): ?string
{
    if (!function_exists('acf_get_options_pages')) {
        return null;
    }

    $pages = acf_get_options_pages();
    if (!is_array($pages) || empty($pages)) {
        return null;
    }

    // Prefer a page labeled "Globals" (client-facing name), otherwise fall back to the first options page.
    $preferred = null;

    foreach ($pages as $p) {
        $menu_slug = $p['menu_slug'] ?? '';
        $menu_title = $p['menu_title'] ?? '';
        $page_title = $p['page_title'] ?? '';

        if (!$menu_slug) {
            continue;
        }

        if (strcasecmp($menu_title, 'Globals') === 0 || strcasecmp($page_title, 'Globals') === 0) {
            $preferred = $menu_slug;
            break;
        }

        // Save first valid slug as fallback
        if ($preferred === null) {
            $preferred = $menu_slug;
        }
    }

    if (!$preferred) {
        return null;
    }

    return admin_url('admin.php?page=' . $preferred);
}

/**
 * Return a whimsical line for the dashboard footer.
 *
 * Keep these short, calm, and non-invasive. (Original lines to avoid licensing/copyright concerns.)
 */
function wpk_get_dashboard_whimsy_line(): string
{
    $lines = [
        'Did you know? Saving often saves your sanity.',
        'Friendly reminder: Little saves now beat big fixes later.',
        'Wanna hear something cool? You can’t break your site by adding content.',
        'Good news: Editing content is safe — that’s what it’s here for.',
        'Pro tip! You can keep a page as a draft until it’s ready for the whole wide world.',
        'No rush: Drafts let you work quietly before hitting publish.',
        'Want to keep your developer happy? Naming your media files helps more than you think 😉',
        'Future you says thanks: Organized media is easier to find later.',
        'Quick win: Previewing a page catches most surprises.',
        'Heads up: A quick preview can save a lot of backtracking.',
        'Small moves: One change at a time makes edits easier to undo.',
        'Steady wins: Clear, simple edits usually work best.',
    ];

    return $lines[array_rand($lines)];
}

/**
 * Render the "Site Overview" widget content.
 */
function wpk_dashboard_render_site_overview_widget(): void
{
    $theme = wp_get_theme();
    $site_name = get_bloginfo('name');
    $env_label = wpk_get_environment_label();
    $globals_url = wpk_get_globals_options_url();

    $links = [];

    // Pages
    if (current_user_can('edit_pages')) {
        $links[] = [
            'label' => 'Create / edit pages',
            'url' => admin_url('edit.php?post_type=page'),
        ];
    }

    // Globals (Options)
    if ($globals_url && current_user_can('edit_posts')) {
        $links[] = [
            'label' => 'Edit site settings (Globals)',
            'url' => $globals_url,
        ];
    }

    // Menus
    if (current_user_can('edit_theme_options')) {
        $links[] = [
            'label' => 'Edit navigation menus',
            'url' => admin_url('nav-menus.php'),
        ];
    }

    // Profile
    if (current_user_can('read')) {
        $links[] = [
            'label' => 'Your profile & admin color scheme',
            'url' => admin_url('profile.php'),
        ];
    }

    echo '<p style="margin-top:0;"><strong>Site:</strong> ' . esc_html($site_name) . '</p>';
    echo '<p style="margin:0 0 12px;"><strong>Environment:</strong> ' . esc_html($env_label) . '</p>';
    echo '<p style="margin:0 0 14px;"><strong>Theme:</strong> ' . esc_html($theme->get('Name')) . '</p>';

    if (!empty($links)) {
        echo '<p style="margin:0 0 6px;"><strong>Quick Start</strong></p>';
        echo '<ul style="margin:0; padding-left:18px;">';

        foreach ($links as $link) {
            echo '<li style="margin: 0 0 6px;"><a href="' . esc_url($link['url']) . '">' . esc_html($link['label']) . '</a></li>';
        }

        echo '</ul>';
    }

    echo '<hr style="margin:14px 0;">';
    echo '<p style="margin:0 0 6px;"><strong>Need help?</strong></p>';
    echo '<p style="margin:0;">Contact Josh: <code>hello@windpeakdesign.com</code></p>';

    echo '<p style="margin:12px 0 0; color:#646970;"><em>' . esc_html(wpk_get_dashboard_whimsy_line()) . '</em></p>';
}
