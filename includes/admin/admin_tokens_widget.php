<?php

/**
 * Admin Dashboard: Tokens Widget
 *
 * Displays token plan info, rollover, available balance (calculated), recent activity,
 * and a "Request Help" button that links to Windpeak's request portal with context.
 *
 * Data source: ACF option fields stored on the "Tokens" options page.
 *
 * Display rules:
 * - Per Month is displayed as a plan reference (not used in calculations).
 * - Available is calculated as: tokens_remaining + token_rollover
 * - Recent activity shows the last 5 log entries.
 *
 * Permissions:
 * - Current behavior: admins only (manage_options).
 * - Future change: when a client-facing role exists, update the capability
 *   check in wpk_tokens_widget_user_can_view() to allow that role to view
 *   the widget without granting access to edit the Tokens options page.
 */

defined('ABSPATH') || exit;

/**
 * True if the current user should see the Tokens widget.
 */
function wpk_tokens_widget_user_can_view(): bool
{
    return current_user_can('manage_options');
}

/**
 * Build a Request Help URL with context parameters for Gravity Forms prefills.
 *
 * Parameters appended:
 * - site       => Site name
 * - url        => Site home URL
 * - user_name  => Current user display name
 * - user_email => Current user email
 */
function wpk_build_token_request_url(string $base_url): string
{
    $site_name = get_bloginfo('name');
    $site_url = home_url('/');

    $user = wp_get_current_user();
    $user_name = $user ? $user->display_name : '';
    $user_email = $user ? $user->user_email : '';

    $params = [
        'site' => $site_name,
        'url' => $site_url,
        'user_name' => $user_name,
        'user_email' => $user_email,
    ];

    $separator = (strpos($base_url, '?') !== false) ? '&' : '?';
    return $base_url . $separator . http_build_query($params);
}

/**
 * Render the Tokens dashboard widget.
 */
function wpk_render_tokens_dashboard_widget(): void
{
    if (!wpk_tokens_widget_user_can_view()) {
        return;
    }

    if (!function_exists('get_field')) {
        echo '<p><strong>Tokens</strong> requires ACF to be active.</p>';
        return;
    }

    // ACF option fields
    $tokens_per_month = (int) (get_field('tokens_per_month', 'option') ?? 0);

    // Available is calculated from these two values and may be negative.
    $tokens_remaining = (int) (get_field('tokens_remaining', 'option') ?? 0);
    $token_rollover = (int) (get_field('token_rollover', 'option') ?? 0);
    $available_tokens = $tokens_remaining + $token_rollover;

    // Request portal URL (base URL only; params are appended in PHP)
    $token_request_url = (string) (get_field('token_request_url', 'option') ?? '');
    if (empty($token_request_url)) {
        $token_request_url = 'https://windpeakdesign.com/request';
    }
    $request_url = wpk_build_token_request_url($token_request_url);

    // Summary row
    echo '<p style="margin:0 0 10px;"><strong>Tokens</strong></p>';

    echo '<p style="margin:0 0 12px;">';
    echo '<strong>Per month:</strong> ' . esc_html((string) $tokens_per_month);
    echo ' &nbsp;|&nbsp; <strong>Rollover:</strong> ' . esc_html(($token_rollover >= 0 ? '+' : '') . (string) $token_rollover);
    echo ' &nbsp;|&nbsp; <strong>Available:</strong> ' . esc_html((string) $available_tokens);
    echo '</p>';

    // Request Help button
    echo '<p style="margin:0 0 14px;">';
    echo '<a class="button button-primary" href="' . esc_url($request_url) . '" target="_blank" rel="noopener noreferrer">Request Help</a>';
    echo '</p>';

    // Recent activity (last 5 entries), shown before token guide
    $rows = get_field('token_log', 'option');
    if (is_array($rows) && !empty($rows)) {
        $rows = array_reverse($rows);
        $rows = array_slice($rows, 0, 5);

        echo '<hr style="margin:14px 0;">';
        echo '<p style="margin:0 0 6px;"><strong>Recent activity</strong></p>';
        echo '<ul style="margin:0; padding-left:18px;">';

        foreach ($rows as $row) {
            $date_raw = (string) ($row['log_date'] ?? '');
            $note = (string) ($row['log_note'] ?? '');
            $used = (int) ($row['tokens_used'] ?? 0);

            $stamp = $date_raw ? strtotime($date_raw) : false;
            $date = $stamp ? date('n/j', $stamp) : $date_raw;

            $note_out = $note ? $note : '(no note)';
            $used_out = '–' . (string) $used;

            echo '<li style="margin:0 0 6px;">' . esc_html($date) . ' — ' . esc_html($note_out) . ' (' . esc_html($used_out) . ' tokens)</li>';
        }

        echo '</ul>';
    }

    // Token guide (how tokens work)
    if (have_rows('token_guide', 'option')) {
        echo '<hr style="margin:14px 0;">';
        echo '<p style="margin:0 0 6px;"><strong>How tokens work</strong></p>';
        echo '<ul style="margin:0; padding-left:18px;">';

        while (have_rows('token_guide', 'option')) {
            the_row();
            $tier_label = (string) (get_sub_field('tier_label') ?? '');
            $tier_desc = (string) (get_sub_field('tier_description') ?? '');

            if (!$tier_label && !$tier_desc) {
                continue;
            }

            echo '<li style="margin:0 0 10px;">';
            if ($tier_label) {
                echo '<strong>' . esc_html($tier_label) . ':</strong> ';
            }
            if ($tier_desc) {
                echo wp_kses_post($tier_desc);
            }
            echo '</li>';
        }

        echo '</ul>';
    }
}

/**
 * Register the dashboard widget.
 */
function wpk_register_tokens_dashboard_widget(): void
{
    if (!wpk_tokens_widget_user_can_view()) {
        return;
    }

    wp_add_dashboard_widget(
        'wpk_tokens_widget',
        'Tokens',
        'wpk_render_tokens_dashboard_widget'
    );
}
add_action('wp_dashboard_setup', 'wpk_register_tokens_dashboard_widget', 40);
