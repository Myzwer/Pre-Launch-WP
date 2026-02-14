<?php

/**
 * Posts / query defaults (blog)
 *
 * Sets sensible defaults for the main blog-related queries and applies optional
 * filter UI parameters from the blog index sidebar.
 *
 * Current behavior:
 * - Blog index uses posts only.
 * - Search defaults to posts only.
 * - Optional sidebar filtering on the blog index:
 *   - pl_cat[] (category IDs)  OR pl_cat=1,2,3
 *   - pl_tag[] (tag IDs)       OR pl_tag=4,5,6
 *
 * @link https://developer.wordpress.org/reference/hooks/pre_get_posts/
 * @link https://developer.wordpress.org/reference/classes/wp_query/is_main_query/
 */

if (! function_exists('prelaunch_parse_id_list')) {
    /**
     * Parses ID lists from either:
     * - array form: [ '5', '8' ]
     * - comma form: "5,8"
     *
     * @param mixed $value Raw input value.
     * @return int[]       Sanitized IDs.
     */
    function prelaunch_parse_id_list($value): array
    {
        if (is_string($value)) {
            $value = preg_split('/\s*,\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
        }

        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter(array_map('absint', $value)));
    }
}

if (! function_exists('prelaunch_normalize_blog_filter_urls')) {
    /**
     * Normalizes filter URLs to a canonical query string (no JS).
     *
     * Examples:
     * - ?s=&pl_cat%5B%5D=5                 -> ?pl_cat=5
     * - ?s&pl_cat%5B0%5D=5                 -> ?pl_cat=5
     * - ?pl_cat%5B%5D=5&pl_cat%5B%5D=8     -> ?pl_cat=5,8
     *
     * Runs only on the blog index (Posts page), including paged URLs.
     */
    function prelaunch_normalize_blog_filter_urls(): void
    {
        if (is_admin() || ! is_home() || empty($_GET)) {
            return;
        }

        $needs_redirect = false;
        $normalized = [];

        // QUERY: Normalize search.
        if (isset($_GET['s'])) {
            $raw_s = (string) wp_unslash($_GET['s']);

            if (trim($raw_s) === '') {
                // Drop empty searches entirely.
                $needs_redirect = true;
            } else {
                $normalized['s'] = $raw_s;
            }
        }

        // QUERY: Normalize cats/tags: arrays -> comma string.
        if (isset($_GET['pl_cat'])) {
            $cat_ids = prelaunch_parse_id_list(wp_unslash($_GET['pl_cat']));

            if (is_array($_GET['pl_cat'])) {
                $needs_redirect = true;
            }

            if (! empty($cat_ids)) {
                $normalized['pl_cat'] = implode(',', $cat_ids);
            } else {
                $needs_redirect = true;
            }
        }

        if (isset($_GET['pl_tag'])) {
            $tag_ids = prelaunch_parse_id_list(wp_unslash($_GET['pl_tag']));

            if (is_array($_GET['pl_tag'])) {
                $needs_redirect = true;
            }

            if (! empty($tag_ids)) {
                $normalized['pl_tag'] = implode(',', $tag_ids);
            } else {
                $needs_redirect = true;
            }
        }

        if (! $needs_redirect) {
            return;
        }

        // Preserve the current page number (paged URLs).
        $paged = max(1, (int) get_query_var('paged'));
        $base_url = strtok(get_pagenum_link($paged), '?');

        $target_url = add_query_arg($normalized, $base_url);
        if (! $target_url) {
            return;
        }

        // NOTE: Compare canonicalized URLs to avoid redirect loops from encoding/order differences.
        $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) wp_unslash($_SERVER['REQUEST_URI']) : '';
        $current_url = esc_url_raw(home_url($request_uri));
        $target_url = esc_url_raw($target_url);

        if ($current_url !== $target_url) {
            wp_safe_redirect($target_url, 302);
            exit;
        }
    }
}
add_action('template_redirect', 'prelaunch_normalize_blog_filter_urls');

if (! function_exists('prelaunch_blog_query_defaults')) {
    /**
     * Applies blog query defaults to the main query on the front end.
     *
     * @param WP_Query $query The WP_Query instance (passed by reference).
     * @return void
     */
    function prelaunch_blog_query_defaults($query): void
    {
        if (is_admin() || ! $query->is_main_query()) {
            return;
        }

        // QUERY: Blog index (Posts page).
        if ($query->is_home()) {
            $query->set('post_type', 'post');

            $default_per_page = (int) get_option('posts_per_page', 10);
            $per_page = (int) apply_filters('prelaunch_blog_posts_per_page', $default_per_page);
            $query->set('posts_per_page', max(1, $per_page));

            prelaunch_apply_blog_sidebar_filters($query);
            return;
        }

        // QUERY: Post archives (category, tag, date, author).
        if ($query->is_archive() && empty($query->get('post_type'))) {
            $query->set('post_type', 'post');

            $default_per_page = (int) get_option('posts_per_page', 10);
            $per_page = (int) apply_filters('prelaunch_archive_posts_per_page', $default_per_page);
            $query->set('posts_per_page', max(1, $per_page));
            return;
        }

        // QUERY: Search results (default to posts only).
        if ($query->is_search()) {
            $search_post_types = apply_filters('prelaunch_search_post_types', ['post']);
            $query->set('post_type', (array) $search_post_types);

            $default_per_page = (int) get_option('posts_per_page', 10);

            // Back-compat: if you were using archive filter for search, this still behaves the same.
            $per_page = (int) apply_filters(
                'prelaunch_search_posts_per_page',
                (int) apply_filters('prelaunch_archive_posts_per_page', $default_per_page)
            );

            $query->set('posts_per_page', max(1, $per_page));
            return;
        }
    }
}
add_action('pre_get_posts', 'prelaunch_blog_query_defaults');

if (! function_exists('prelaunch_apply_blog_sidebar_filters')) {
    /**
     * Applies blog index sidebar filters to the main query.
     *
     * Filter parameters (GET):
     * - pl_cat[] or pl_cat=1,2,3
     * - pl_tag[] or pl_tag=4,5,6
     *
     * Logic:
     * - AND across groups (category AND tag AND search).
     * - OR within each group (any selected categories; any selected tags).
     *
     * @param WP_Query $query The WP_Query instance (passed by reference).
     * @return void
     */
    function prelaunch_apply_blog_sidebar_filters($query): void
    {
        $raw_cats = isset($_GET['pl_cat']) ? wp_unslash($_GET['pl_cat']) : [];
        $raw_tags = isset($_GET['pl_tag']) ? wp_unslash($_GET['pl_tag']) : [];

        $cat_ids = prelaunch_parse_id_list($raw_cats);
        $tag_ids = prelaunch_parse_id_list($raw_tags);

        if (empty($cat_ids) && empty($tag_ids)) {
            return;
        }

        $tax_query = ['relation' => 'AND'];

        if (! empty($cat_ids)) {
            $tax_query[] = [
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $cat_ids,
                'operator' => 'IN',
                'include_children' => true,
            ];
        }

        if (! empty($tag_ids)) {
            $tax_query[] = [
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tag_ids,
                'operator' => 'IN',
            ];
        }

        $query->set('tax_query', $tax_query);
    }
}
