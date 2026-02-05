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

/**
 * Small helper to parse ID lists from either:
 * - array form: [ '5', '8' ]
 * - comma form: "5,8"
 *
 * @param mixed $value
 * @return int[]
 */
function prelaunch_parse_id_list($value)
{
    if (is_string($value)) {
        $value = preg_split('/\s*,\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
    }

    if (! is_array($value)) {
        return [];
    }

    $ids = array_values(array_filter(array_map('absint', $value)));
    return $ids;
}

/**
 * Normalize ugly filter URLs to cleaner ones (no JS).
 *
 * Examples:
 * - ?s=&pl_cat%5B%5D=5   -> ?pl_cat=5
 * - ?s&pl_cat%5B0%5D=5   -> ?pl_cat=5
 * - ?pl_cat%5B%5D=5&pl_cat%5B%5D=8 -> ?pl_cat=5,8
 *
 * Runs only on the blog index (Posts page), including paged URLs.
 *
 * This is a WordPress thing: template_redirect is the right place to safely redirect
 * after WP has resolved what template/query we’re on.
 */
function prelaunch_normalize_blog_filter_urls()
{
    if (is_admin()) {
        return;
    }

    if (! is_home()) {
        return;
    }

    // Nothing to normalize if there are no query args.
    if (empty($_GET)) {
        return;
    }

    $needs_redirect = false;
    $normalized = [];

    // Normalize search.
    if (isset($_GET['s'])) {
        $raw_s = (string) wp_unslash($_GET['s']);

        // Drop empty searches entirely.
        if (trim($raw_s) === '') {
            $needs_redirect = true;
        } else {
            $normalized['s'] = $raw_s;
        }
    }

    // Normalize cats/tags: arrays -> comma string.
    if (isset($_GET['pl_cat'])) {
        $cat_ids = prelaunch_parse_id_list(wp_unslash($_GET['pl_cat']));

        // If it came in as an array (bracket notation), we’ll normalize.
        if (is_array($_GET['pl_cat'])) {
            $needs_redirect = true;
        }

        if (! empty($cat_ids)) {
            $normalized['pl_cat'] = implode(',', $cat_ids);
        } else {
            // If empty array exists, drop it.
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

    // If nothing changed, do nothing.
    if (! $needs_redirect) {
        return;
    }

    // Preserve the current page number (paged URLs).
    $paged = max(1, (int) get_query_var('paged'));
    $base_url = strtok(get_pagenum_link($paged), '?');

    $target_url = add_query_arg($normalized, $base_url);

    // Avoid redirect loops.
    $current_url = (is_ssl() ? 'https://' : 'http://') . wp_unslash($_SERVER['HTTP_HOST']) . wp_unslash($_SERVER['REQUEST_URI']);

    if ($target_url && $current_url !== $target_url) {
        wp_safe_redirect($target_url, 302);
        exit;
    }
}
add_action('template_redirect', 'prelaunch_normalize_blog_filter_urls');

/**
 * Apply blog query defaults to the main query on the front end.
 *
 * @param WP_Query $query The WP_Query instance (passed by reference).
 * @return void
 */
function prelaunch_blog_query_defaults($query)
{
    // Never modify queries in the admin.
    if (is_admin()) {
        return;
    }

    // Only target the main query (avoid affecting custom loops/widgets).
    if (! $query->is_main_query()) {
        return;
    }

    /**
     * Blog index (the "Posts page" set in Settings → Reading).
     */
    if ($query->is_home()) {
        $query->set('post_type', 'post');

        $default_per_page = (int) get_option('posts_per_page', 10);
        $per_page = (int) apply_filters('prelaunch_blog_posts_per_page', $default_per_page);
        $query->set('posts_per_page', max(1, $per_page));

        // Apply optional sidebar filters (pl_cat + pl_tag).
        prelaunch_apply_blog_sidebar_filters($query);

        return;
    }

    /**
     * Post archives (category, tag, date, author).
     */
    if ($query->is_archive() && $query->get('post_type') === '') {
        $query->set('post_type', 'post');

        $default_per_page = (int) get_option('posts_per_page', 10);
        $per_page = (int) apply_filters('prelaunch_archive_posts_per_page', $default_per_page);
        $query->set('posts_per_page', max(1, $per_page));

        return;
    }

    /**
     * Search results.
     *
     * Default to searching posts only.
     */
    if ($query->is_search()) {
        $search_post_types = apply_filters('prelaunch_search_post_types', [ 'post' ]);
        $query->set('post_type', (array) $search_post_types);

        $default_per_page = (int) get_option('posts_per_page', 10);
        $per_page = (int) apply_filters('prelaunch_archive_posts_per_page', $default_per_page);
        $query->set('posts_per_page', max(1, $per_page));

        return;
    }
}
add_action('pre_get_posts', 'prelaunch_blog_query_defaults');

/**
 * Apply blog index sidebar filters to the main query.
 *
 * Filter parameters (GET):
 * - pl_cat[] or pl_cat=1,2,3
 * - pl_tag[] or pl_tag=4,5,6
 *
 * Logic:
 * - AND across filter groups (category group AND tag group AND search).
 * - OR within each group (any selected categories; any selected tags).
 *
 * @param WP_Query $query The WP_Query instance (passed by reference).
 * @return void
 */
function prelaunch_apply_blog_sidebar_filters($query)
{
    $raw_cats = isset($_GET['pl_cat']) ? wp_unslash($_GET['pl_cat']) : [];
    $raw_tags = isset($_GET['pl_tag']) ? wp_unslash($_GET['pl_tag']) : [];

    $cat_ids = prelaunch_parse_id_list($raw_cats);
    $tag_ids = prelaunch_parse_id_list($raw_tags);

    if (empty($cat_ids) && empty($tag_ids)) {
        return;
    }

    $tax_query = [ 'relation' => 'AND' ];

    if (! empty($cat_ids)) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $cat_ids,
            'operator' => 'IN', // OR within group.
            'include_children' => true,
        ];
    }

    if (! empty($tag_ids)) {
        $tax_query[] = [
            'taxonomy' => 'post_tag',
            'field' => 'term_id',
            'terms' => $tag_ids,
            'operator' => 'IN', // OR within group.
        ];
    }

    $query->set('tax_query', $tax_query);
}
