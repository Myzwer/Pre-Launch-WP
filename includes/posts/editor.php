<?php

/**
 * Blog editor policy (Posts only).
 *
 * Goals:
 * - Restrict Gutenberg block list for post_type=post.
 * - Keep the editor content-focused (no layout/page-builder blocks).
 * - Enforce a strict embed policy by only allowing YouTube/Vimeo embed blocks.
 * - Keep Gravity Forms blocks available.
 *
 * Notes:
 * - This is intentionally a whitelist. Anything not listed is unavailable in the editor UI.
 * - This is editor-facing policy only; it does not change frontend templates or styling.
 */

defined('ABSPATH') || exit;

/**
 * Restrict blocks available in the block editor for Posts.
 *
 * WordPress 5.5+ provides $editor_context with the current post object.
 */
add_filter('allowed_block_types_all', function ($allowed_block_types, $editor_context) {
    // Only restrict the block editor for standard Posts.
    if (empty($editor_context->post) || $editor_context->post->post_type !== 'post') {
        return $allowed_block_types;
    }

    // Keep this list intentionally small and "article-first".
    // Anything NOT listed here will be unavailable in the inserter for Posts.
    return [
        // Text
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/quote',

        // Media (article-safe only)
        'core/image',
        'core/gallery',

        // Tables
        'core/table',

        // Buttons (we'll style these to match Tailwind in editor CSS later)
        'core/buttons',
        'core/button',

        // Embeds (strict allowlist)
        // We intentionally do NOT allow core/embed or broad providers.
        'core-embed/youtube',
        'core-embed/vimeo',

        // Gravity Forms (must remain usable)
        'gravityforms/form',
    ];
}, 10, 2);
