<?php

/**
 * Editor Policy + Brand Color Tokens
 *
 * Goals:
 * - Restrict Gutenberg block list for post_type=post.
 * - Define a strict, brand-only color palette.
 * - Disable arbitrary custom colors & gradients.
 *
 * Notes:
 * - Brand colors are defined once in $brand_colors.
 * - If you update Tailwind tokens, update the hex here as well.
 * - The palette is site-wide by design.
 */

defined('ABSPATH') || exit;

/**
 * ------------------------------------------------------------------------
 * Brand Color Tokens
 * ------------------------------------------------------------------------
 *
 * Single source of truth for editor palette.
 * Keep naming consistent with Tailwind tokens.
 */

$brand_colors = [
    // Neutrals
    'black' => '#0F172A',
    'white' => '#F8FAFC',

    // Brand roles (saturated)
    'primary' => '#63C1E9',
    'secondary' => '#397B52',

    // Soft roles (pastels)
    'soft-1' => '#E0F2FE',
    'soft-2' => '#ECFDF3',
];

/**
 * Register editor color palette + disable custom colors.
 */
add_action('after_setup_theme', function () use ($brand_colors) {

    add_theme_support('editor-color-palette', [

        [
            'name' => __('Black', 'prelaunch-wp'),
            'slug' => 'black',
            'color' => $brand_colors['black'],
        ],
        [
            'name' => __('White', 'prelaunch-wp'),
            'slug' => 'white',
            'color' => $brand_colors['white'],
        ],

        [
            'name' => __('Primary', 'prelaunch-wp'),
            'slug' => 'primary',
            'color' => $brand_colors['primary'],
        ],
        [
            'name' => __('Secondary', 'prelaunch-wp'),
            'slug' => 'secondary',
            'color' => $brand_colors['secondary'],
        ],

        [
            'name' => __('Soft 1', 'prelaunch-wp'),
            'slug' => 'soft-1',
            'color' => $brand_colors['soft-1'],
        ],
        [
            'name' => __('Soft 2', 'prelaunch-wp'),
            'slug' => 'soft-2',
            'color' => $brand_colors['soft-2'],
        ],
    ]);

    // Prevent off-brand chaos.
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-gradients');

});

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

/**
 * Force "text color only" in the block editor by removing background color support.
 *
 * Why this works:
 * - Many blocks set supports['color'] = true (boolean), which implicitly enables background.
 * - We normalize that to an explicit array: text=true, background=false.
 */
add_filter('register_block_type_args', function (array $args, string $block_name): array {

    if (empty($args['supports']) || !is_array($args['supports'])) {
        return $args;
    }

    // Normalize supports['color'] from boolean to explicit array so we can disable background.
    if (isset($args['supports']['color']) && $args['supports']['color'] === true) {
        $args['supports']['color'] = [
            'text' => true,
            'background' => false,
            'gradients' => false,
            // Optional: keep link color off too (usually a good idea for posts)
            'link' => false,
        ];
    }

    // If it's already an array, explicitly remove background + gradients.
    if (isset($args['supports']['color']) && is_array($args['supports']['color'])) {
        $args['supports']['color']['background'] = false;
        $args['supports']['color']['gradients'] = false;
    }

    // Some blocks expose a separate background support flag.
    if (isset($args['supports']['background'])) {
        $args['supports']['background'] = false;
    }

    return $args;
}, 100, 2);

/**
 * Define controlled editor font size presets.
 *
 * Why:
 * - Replace WordPress default S/M/L/XL sizes.
 * - Keep typography within a sane range.
 * - Allow custom font sizes via slider.
 */
add_action('after_setup_theme', function () {

    add_theme_support('editor-font-sizes', [
        [
            'name' => __('Small', 'prelaunch-wp'),
            'slug' => 'small',
            'size' => '0.8em',
        ],
        [
            'name' => __('Medium', 'prelaunch-wp'),
            'slug' => 'medium',
            'size' => '1em',
        ],
        [
            'name' => __('Large', 'prelaunch-wp'),
            'slug' => 'large',
            'size' => '1.2em',
        ],
        [
            'name' => __('XL', 'prelaunch-wp'),
            'slug' => 'xl',
            'size' => '1.5em',
        ],
    ]);

    // Make sure custom font sizes remain enabled (slider stays available).
    add_theme_support('custom-font-sizes');

});

/**
 * Register branded button styles for the core Button block.
 *
 * Goals:
 * - Replace WP defaults (Fill / Outline) with branded button variants.
 * - Keep markup standard (core/button) for maximum compatibility.
 *
 * Output behavior:
 * - Selecting a style adds: .is-style-{name} on the .wp-block-button wrapper.
 */
/**
 * Button block styles: remove WP defaults + add branded variants.
 *
 * Why priority 100?
 * - Core registers default block styles on init.
 * - We run after core so our unregister "sticks."
 */
add_action('init', function () {

    // Safety: only available in modern WP.
    if (!function_exists('unregister_block_style') || !function_exists('register_block_style')) {
        return;
    }

    /**
     * Remove default button styles.
     * Note: Some WP versions register these on core/button.
     * (core/buttons is the wrapper block; styles are generally on core/button.)
     */
    unregister_block_style('core/button', 'fill');
    unregister_block_style('core/button', 'outline');

    // Add your branded variants.
    register_block_style('core/button', [
        'name' => 'btn-secondary',
        'label' => __('Secondary', 'prelaunch-wp'),
    ]);

    register_block_style('core/button', [
        'name' => 'btn-light',
        'label' => __('Light', 'prelaunch-wp'),
    ]);

    register_block_style('core/button', [
        'name' => 'btn-dark',
        'label' => __('Dark', 'prelaunch-wp'),
    ]);

    register_block_style('core/button', [
        'name' => 'btn-ghost-white',
        'label' => __('Ghost (White)', 'prelaunch-wp'),
    ]);

    register_block_style('core/button', [
        'name' => 'btn-ghost-black',
        'label' => __('Ghost (Black)', 'prelaunch-wp'),
    ]);

}, 100);
