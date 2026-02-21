<?php

/**
 * SEO Integration
 * ---------------
 * Theme-level integration points for The SEO Framework (TSF) on ACF-first sites.
 *
 * - Description: ACF Flex (body_sections) OR regular ACF fields; otherwise TSF defaults (posts).
 * - Social image: last-resort ACF Options fallback image (fallback_image).
 */

declare(strict_types=1);

/**
 * Generated meta description fallback for ACF-first sites.
 *
 * Filter: the_seo_framework_generated_description
 * Scope: singular only
 *
 * Order:
 * 1) TSF manual description (wins outside "generated" pipeline)
 * 2) ACF Flex (body_sections)
 * 3) Regular ACF fields (priority list, then generic scan)
 * 4) TSF defaults (posts)
 */
add_filter('the_seo_framework_generated_description', 'prelaunch_tsf_generated_description_fallback', 10, 2);

function prelaunch_tsf_generated_description_fallback(string $desc, ?array $args): string
{
    if (!function_exists('tsf')) {
        return $desc;
    }

    // Posts generally have no ACF; this keeps TSF defaults intact.
    if (!function_exists('get_field') || !function_exists('get_fields')) {
        return $desc;
    }

    $tsfquery = tsf()->query();
    if (!$tsfquery || !method_exists($tsfquery, 'is_singular')) {
        return $desc;
    }

    if (!$tsfquery->is_singular()) {
        return $desc;
    }

    $post_id = method_exists($tsfquery, 'get_the_real_id') ? (int) $tsfquery->get_the_real_id() : 0;
    if ($post_id <= 0) {
        return $desc;
    }

    // 2) ACF Flex takes precedence when present.
    $body_sections = get_field('body_sections', $post_id);
    if (is_array($body_sections) && !empty($body_sections)) {
        $text = prelaunch_extract_first_meaningful_text_from_flex($body_sections);
        return $text !== '' ? prelaunch_trim_meta_description($text) : $desc;
    }

    // 3) Regular ACF fields fallback when flex is not present.
    $priority_fields = [
        'page_intro',
        'intro_text',
        'summary',
    ];

    // Keys commonly used for UI, labels, media, or short snippets.
    $exclude_fields = [
        'title',
        'subtitle',
        'highlight_1',
        'highlight_2',
        'highlight_3',
        'video_background',
        'primary_cta_button',
    ];

    $text = prelaunch_extract_first_meaningful_text_from_acf_fields($post_id, $priority_fields, $exclude_fields);

    return $text !== '' ? prelaunch_trim_meta_description($text) : $desc;
}

function prelaunch_extract_first_meaningful_text_from_flex(array $rows): string
{
    foreach ($rows as $row) {
        if (!is_array($row)) {
            continue;
        }

        foreach ($row as $key => $value) {
            if ($key === 'acf_fc_layout') {
                continue;
            }

            if (is_array($value) || is_object($value)) {
                continue;
            }

            $text = prelaunch_clean_text((string) $value);
            if ($text !== '' && mb_strlen($text) >= 60) {
                return $text;
            }
        }
    }

    return '';
}

function prelaunch_extract_first_meaningful_text_from_acf_fields(
    int $post_id,
    array $priority_fields = [],
    array $exclude_fields = []
): string {
    // 1) Priority fields first (convention-based).
    foreach ($priority_fields as $field_name) {
        $value = get_field($field_name, $post_id);
        $text = prelaunch_flatten_to_text($value);

        if ($text !== '' && mb_strlen($text) >= 60) {
            return $text;
        }
    }

    // 2) Generic scan over all ACF fields on the post.
    $all = get_fields($post_id);
    if (!is_array($all) || empty($all)) {
        return '';
    }

    foreach ($all as $key => $value) {
        if (in_array((string) $key, $exclude_fields, true)) {
            continue;
        }

        $text = prelaunch_flatten_to_text($value);

        if ($text !== '' && mb_strlen($text) >= 60) {
            return $text;
        }
    }

    return '';
}

/**
 * Flattens common ACF field value types to clean text.
 * Arrays/objects (repeaters, images, groups) are ignored by default.
 */
function prelaunch_flatten_to_text($value): string
{
    if (is_string($value)) {
        return prelaunch_clean_text($value);
    }

    return '';
}

function prelaunch_clean_text(string $text): string
{
    $text = strip_shortcodes($text);
    $text = wp_strip_all_tags($text);
    $text = trim((string) preg_replace('/\s+/', ' ', $text));
    return $text;
}

function prelaunch_trim_meta_description(string $text): string
{
    // Targets TSF's stricter length heuristic to keep DG green more often.
    return wp_html_excerpt($text, 150, '…');
}

/**
 * Social image fallback generator.
 *
 * Filter: the_seo_framework_image_generation_params
 * Scope: social only
 *
 * Adds a last-resort generator that returns the ACF option field `fallback_image`.
 * TSF manual social image, featured image, etc. remain higher priority.
 */
add_filter('the_seo_framework_image_generation_params', 'prelaunch_tsf_social_image_fallback_params', 10, 3);

function prelaunch_tsf_social_image_fallback_params(array $params, $args = null, string $context = 'social'): array
{
    if ($context !== 'social') {
        return $params;
    }

    $params['fallback'] ??= [];

    if (!is_array($params['fallback'])) {
        $params['fallback'] = [];
    }

    $params['fallback']['prelaunch_fallback_image'] = 'prelaunch_tsf_fallback_image_generator';

    return $params;
}

/**
 * @generator
 * Yields a single image candidate for TSF social previews.
 */
function prelaunch_tsf_fallback_image_generator($args = null, string $size = 'full'): Generator
{
    if (!function_exists('get_field')) {
        yield ['url' => '', 'id' => 0];
        return;
    }

    $fallback = get_field('fallback_image', 'option');

    $url = '';
    $id = 0;

    if (is_array($fallback)) {
        $url = isset($fallback['url']) ? (string) $fallback['url'] : '';
        $id = isset($fallback['ID']) ? (int) $fallback['ID'] : 0;
    } elseif (is_numeric($fallback)) {
        $id = (int) $fallback;
        $url = wp_get_attachment_image_url($id, $size) ?: '';
    } elseif (is_string($fallback)) {
        $url = trim($fallback);
    }

    yield ['url' => $url, 'id' => $id];
}
