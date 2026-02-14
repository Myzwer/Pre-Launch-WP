<?php

/**
 * Posts / content setup
 *
 * Registers theme supports related to post content (blog now, reusable for future CPTs).
 * Hooked into after_setup_theme so WordPress loads supports at the correct time.
 *
 * @link https://developer.wordpress.org/reference/hooks/after_setup_theme/
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 */

if (! function_exists('prelaunch_posts_setup')) {
    function prelaunch_posts_setup(): void
    {
        // FEATURE: Featured images (post thumbnails).
        add_theme_support('post-thumbnails');

        // FEATURE: Use valid HTML5 markup for core templates.
        // @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]);

        // EDITOR: Gutenberg compatibility defaults.
        // @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/
        add_theme_support('wp-block-styles');
        add_theme_support('editor-styles');

        // EDITOR: Allow wide/full alignments for blocks.
        add_theme_support('align-wide');

        // FEATURE: Responsive embeds for oEmbed content.
        add_theme_support('responsive-embeds');
    }
}

add_action('after_setup_theme', 'prelaunch_posts_setup');
