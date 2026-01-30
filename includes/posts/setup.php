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

function prelaunch_posts_setup()
{
    /**
     * Featured images (post thumbnails).
     *
     * Used by blog posts and commonly reused by CPTs later.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Use valid HTML5 markup for core templates.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]
    );

    /**
     * Editor-related supports (Gutenberg compatibility).
     *
     * These are safe defaults for a starter theme even if most pages use ACF.
     * If you decide to keep the editor "unstyled," we can remove editor-styles later.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/
     */
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');

    /**
     * Allow wide/full alignments for blocks.
     * Optional, but commonly expected for blog content.
     */
    add_theme_support('align-wide');

    /**
     * Responsive embeds for oEmbed content.
     */
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'prelaunch_posts_setup');
