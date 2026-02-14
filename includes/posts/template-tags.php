<?php

/**
 * Posts / template tags
 *
 * Small, reusable helpers for blog templates (cards, archives, single posts).
 * Keep these functions focused on rendering commonly repeated post meta and term lists.
 *
 * Notes:
 * - Output helpers escape wrapper attributes. Term lists are kses-filtered on output.
 *
 * @link https://developer.wordpress.org/themes/basics/template-tags/
 * @link https://developer.wordpress.org/themes/basics/security/#escaping
 */

/**
 * Output post date markup.
 *
 * Prints a linked published date only.
 * Modified dates are intentionally not displayed, even if the post was updated.
 *
 * @param int|\WP_Post|null $post Post ID or object. Defaults to current post in the loop.
 * @param array            $args Optional arguments.
 *
 * @return void
 */
function prelaunch_posted_on(int|WP_Post $post = null, array $args = []): void
{
    $post = get_post($post);

    if (! $post instanceof WP_Post) {
        return;
    }

    $args = array_merge([
        'class' => 'post-date',
    ], $args);

    $published_w3c = get_the_date(DATE_W3C, $post);
    $published_hum = get_the_date('', $post);

    echo '<span class="' . esc_attr($args['class']) . '">';
    echo '<a href="' . esc_url(get_permalink($post)) . '" rel="bookmark">';
    echo '<time class="published updated" datetime="' . esc_attr($published_w3c) . '">';
    echo esc_html($published_hum);
    echo '</time>';
    echo '</a>';
    echo '</span>';
}

/**
 * Output a term list for a taxonomy on the current post.
 *
 * @param string            $taxonomy Taxonomy name (e.g. 'category', 'post_tag').
 * @param array             $args     Optional arguments.
 * @param int|\WP_Post|null $post     Post ID or object. Defaults to current post in the loop.
 * @return void
 */
if (! function_exists('prelaunch_post_terms')) {
    function prelaunch_post_terms(string $taxonomy, array $args = [], $post = null): void
    {
        $post = get_post($post);

        if (! $post instanceof WP_Post) {
            return;
        }

        if ($taxonomy === '' || ! taxonomy_exists($taxonomy)) {
            return;
        }

        $args = array_merge([
            'class' => 'post-terms',
            'separator' => ', ',
            'before' => '',
            'after' => '',
        ], $args);

        $term_list = get_the_term_list(
            $post->ID,
            $taxonomy,
            $args['before'],
            $args['separator'],
            $args['after']
        );

        if (empty($term_list) || is_wp_error($term_list)) {
            return;
        }

        echo '<span class="' . esc_attr($args['class']) . '">';
        echo wp_kses_post($term_list);
        echo '</span>';
    }
}

/**
 * Return the post excerpt with a consistent fallback.
 *
 * Uses the manual excerpt when present; otherwise uses the generated excerpt.
 *
 * @param int|\WP_Post|null $post Post ID or object. Defaults to current post in the loop.
 * @return string
 */
if (! function_exists('prelaunch_get_excerpt')) {
    function prelaunch_get_excerpt($post = null): string
    {
        $post = get_post($post);

        if (! $post instanceof WP_Post) {
            return '';
        }

        // get_the_excerpt() uses manual excerpt when present; otherwise generates from content.
        return (string) get_the_excerpt($post);
    }
}

/**
 * Return estimated reading time for a post.
 *
 * Calculates reading time based on word count of post content.
 * Defaults to 200 words per minute.
 *
 * @param int|\WP_Post|null $post Post ID or object. Defaults to current post.
 * @param array            $args Optional arguments.
 * @return string
 */
if (! function_exists('prelaunch_get_reading_time')) {
    function prelaunch_get_reading_time($post = null, array $args = []): string
    {
        $post = get_post($post);

        if (! $post instanceof WP_Post) {
            return '';
        }

        $args = array_merge([
            'words_per_minute' => 200,
            'suffix' => __('min read', 'prelaunch-wp'),
        ], $args);

        $content = (string) get_post_field('post_content', $post->ID);
        if ($content === '') {
            return '';
        }

        $content = wp_strip_all_tags($content);
        $word_count = str_word_count($content);

        if ($word_count === 0) {
            return '';
        }

        $minutes = (int) ceil($word_count / max(1, (int) $args['words_per_minute']));

        return sprintf(
            /* translators: 1: reading time number, 2: reading time suffix */
            esc_html__('%1$d %2$s', 'prelaunch-wp'),
            $minutes,
            $args['suffix']
        );
    }
}

/**
 * Displays a human-readable post date.
 *
 * Behavior:
 * - Shows "Just now" for posts under 1 hour old
 * - Shows "X hours ago" for posts under 24 hours old
 * - Shows "X days ago" for posts under 7 days old
 * - Falls back to WordPress formatted date for older posts
 *
 * @param string $format Optional. PHP date format passed to get_the_date().
 *                       Default empty string uses WordPress date settings.
 *
 * @return string Human-readable date string.
 */
if (! function_exists('prelaunch_display_date')) {
    function prelaunch_display_date(string $format = ''): string
    {
        $post_time = (int) get_the_time('U');            // publish timestamp
        $current_time = (int) current_time('timestamp');    // WP "now" timestamp
        $seconds = $current_time - $post_time;

        // If future-dated (scheduled) or something weird, show normal date.
        if ($seconds < 0) {
            return (string) get_the_date($format);
        }

        $hours = (int) floor($seconds / 3600);

        if ($hours < 1) {
            return (string) __('Just now', 'prelaunch-wp');
        }

        if ($hours < 24) {
            return sprintf(
                /* translators: %s: number of hours */
                _n('%s hour ago', '%s hours ago', $hours, 'prelaunch-wp'),
                number_format_i18n($hours)
            );
        }

        $days = (int) floor($seconds / 86400);

        if ($days < 7) {
            return sprintf(
                /* translators: %s: number of days */
                _n('%s day ago', '%s days ago', $days, 'prelaunch-wp'),
                number_format_i18n($days)
            );
        }

        return (string) get_the_date($format);
    }
}

/**
 * Get a WP_Query of related posts for a given post.
 *
 * Related order:
 * 1) Same categories
 * 2) Same tags
 * 3) Recent posts fallback
 *
 * @param int|\WP_Post|null $post Post ID or object. Defaults to current post.
 * @param array            $args Optional args.
 * @return WP_Query
 */
if (! function_exists('prelaunch_get_related_posts_query')) {
    function prelaunch_get_related_posts_query($post = null, array $args = []): WP_Query
    {
        $post = get_post($post);

        $args = array_merge([
            'posts_per_page' => 3,
            'category_first' => true,
            'tag_fallback' => true,
            'recent_fallback' => true,
            'ignore_sticky' => true,
        ], $args);

        if (! $post instanceof WP_Post) {
            return new WP_Query(['post_type' => 'post', 'posts_per_page' => 0]);
        }

        $base_query_args = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => max(1, (int) $args['posts_per_page']),
            'post__not_in' => [(int) $post->ID],
            'ignore_sticky_posts' => ! empty($args['ignore_sticky']),
            'no_found_rows' => true,
        ];

        // QUERY: Categories first.
        if (! empty($args['category_first'])) {
            $cat_ids = wp_get_post_terms($post->ID, 'category', ['fields' => 'ids']);

            if (! is_wp_error($cat_ids) && ! empty($cat_ids)) {
                $q = new WP_Query(array_merge($base_query_args, [
                    'tax_query' => [[
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => array_map('absint', $cat_ids),
                    ]],
                ]));

                if ($q->have_posts()) {
                    return $q;
                }
            }
        }

        // QUERY: Tags fallback.
        if (! empty($args['tag_fallback'])) {
            $tag_ids = wp_get_post_terms($post->ID, 'post_tag', ['fields' => 'ids']);

            if (! is_wp_error($tag_ids) && ! empty($tag_ids)) {
                $q = new WP_Query(array_merge($base_query_args, [
                    'tax_query' => [[
                        'taxonomy' => 'post_tag',
                        'field' => 'term_id',
                        'terms' => array_map('absint', $tag_ids),
                    ]],
                ]));

                if ($q->have_posts()) {
                    return $q;
                }
            }
        }

        // QUERY: Recent fallback.
        if (! empty($args['recent_fallback'])) {
            return new WP_Query(array_merge($base_query_args, [
                'orderby' => 'date',
                'order' => 'DESC',
            ]));
        }

        return new WP_Query(['post_type' => 'post', 'posts_per_page' => 0]);
    }
}

/**
 * Output a minimal related posts section.
 *
 * This prints basic markup only. Styling is handled by your theme classes.
 *
 * @param int|\WP_Post|null $post Post ID or object. Defaults to current post.
 * @param array            $args Optional args.
 * @return void
 */
if (! function_exists('prelaunch_related_posts')) {
    function prelaunch_related_posts($post = null, array $args = []): void
    {
        $args = array_merge([
            'title' => __('Related posts', 'prelaunch-wp'),
            'posts_per_page' => 3,
        ], $args);

        $q = prelaunch_get_related_posts_query($post, [
            'posts_per_page' => (int) $args['posts_per_page'],
        ]);

        if (! $q->have_posts()) {
            return;
        }

        echo '<section class="related-posts" aria-label="' . esc_attr__('Related posts', 'prelaunch-wp') . '">';
        echo '<h2 class="related-posts__title">' . esc_html($args['title']) . '</h2>';
        echo '<div class="related-posts__list">';

        while ($q->have_posts()) {
            $q->the_post();

            echo '<article class="related-posts__item">';
            echo '<h3 class="related-posts__item-title"><a href="' . esc_url(get_permalink()) . '">';
            the_title();
            echo '</a></h3>';

            if (function_exists('prelaunch_posted_on')) {
                prelaunch_posted_on();
            }

            echo '</article>';
        }

        echo '</div>';
        echo '</section>';

        wp_reset_postdata();
    }
}
