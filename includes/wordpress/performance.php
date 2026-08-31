<?php

/**
 * Front-end performance
 * ---------------------
 * Lighthouse-oriented loading: defer JS, non-blocking webfont CSS, drop emoji
 * and unused block-library CSS on ACF-first views.
 */

declare(strict_types=1);

/**
 * Whether this request needs core Gutenberg styles.
 *
 * Flex pages do not print `the_content()`, so wp-block-library is unused there.
 */
function prelaunch_front_needs_block_styles(): bool
{
    return is_singular('post') || is_home() || is_archive() || is_search();
}

/**
 * Dequeue render-blocking assets that this theme does not use on the view.
 */
function prelaunch_dequeue_unused_front_styles(): void
{
    if (is_admin()) {
        return;
    }

    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('wp-block-library-theme');

    if (! prelaunch_front_needs_block_styles()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('prelaunch-blocks');
    }
}

add_action('wp_enqueue_scripts', 'prelaunch_dequeue_unused_front_styles', 100);

/**
 * Remove emoji scripts/styles on the front end.
 */
function prelaunch_disable_front_emojis(): void
{
    if (is_admin()) {
        return;
    }

    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_enqueue_scripts', 'wp_enqueue_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}

add_action('init', 'prelaunch_disable_front_emojis');

/**
 * Stylesheets that should not block first paint.
 *
 * @return string[]
 */
function prelaunch_nonblocking_style_handles(): array
{
    return [
        'prelaunch-google-fonts',
        'prelaunch-fa-core',
        'prelaunch-fa-solid',
        'prelaunch-fa-regular',
        'prelaunch-fa-brands',
    ];
}

/**
 * Load selected stylesheets as print, then swap to all after download.
 *
 * @param string $html   Link tag.
 * @param string $handle Style handle.
 */
function prelaunch_nonblocking_style_loader_tag(string $html, string $handle): string
{
    if (! in_array($handle, prelaunch_nonblocking_style_handles(), true)) {
        return $html;
    }

    if (str_contains($html, 'onload=')) {
        return $html;
    }

    $async = preg_replace("/media=(['\"])all\\1/", 'media="print" onload="this.media=\'all\'"', $html, 1);

    if (! is_string($async) || $async === $html) {
        $async = str_replace(' />', ' media="print" onload="this.media=\'all\'" />', $html);
    }

    return $async . '<noscript>' . $html . '</noscript>';
}

add_filter('style_loader_tag', 'prelaunch_nonblocking_style_loader_tag', 10, 2);
