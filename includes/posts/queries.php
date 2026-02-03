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
 *   - pl_cat[] (category IDs)
 *   - pl_tag[] (tag IDs)
 *
 * @link https://developer.wordpress.org/reference/hooks/pre_get_posts/
 * @link https://developer.wordpress.org/reference/classes/wp_query/is_main_query/
 */

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

        // Apply optional sidebar filters (pl_cat[] + pl_tag[]).
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
 * - pl_cat[]: Category term IDs
 * - pl_tag[]: Tag term IDs
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
    $raw_cats = isset($_GET['pl_cat']) ? (array) wp_unslash($_GET['pl_cat']) : [];
    $raw_tags = isset($_GET['pl_tag']) ? (array) wp_unslash($_GET['pl_tag']) : [];

    $cat_ids = array_values(array_filter(array_map('absint', $raw_cats)));
    $tag_ids = array_values(array_filter(array_map('absint', $raw_tags)));

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
