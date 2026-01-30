<?php

/**
 * Posts / query defaults (blog)
 *
 * Sets sensible defaults for the main blog-related queries:
 * - Posts page (blog index)
 * - Category/tag/date archives
 * - Search results
 *
 * This file intentionally targets core "post" queries only. CPTs can opt-in later
 * via a dedicated CPT module without changing this file.
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
function prelaunch_blog_query_defaults($query): void
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
     *
     * This also covers the case where the blog is the homepage, but your default
     * is a static homepage + a posts page at /blog/.
     */
    if ($query->is_home()) {
        $query->set('post_type', 'post');

        /**
         * Default blog page size.
         * Override per-site via filter without editing theme files.
         */
        $per_page = (int) apply_filters('prelaunch_blog_posts_per_page', 10);
        $query->set('posts_per_page', max(1, $per_page));

        return;
    }

    /**
     * Post archives (category, tag, date, author).
     */
    if ($query->is_archive() && $query->get('post_type') === '') {
        $query->set('post_type', 'post');

        $per_page = (int) apply_filters('prelaunch_archive_posts_per_page', 10);
        $query->set('posts_per_page', max(1, $per_page));

        return;
    }

    /**
     * Search results.
     *
     * Default to searching posts only. This matches your "blog is the only Gutenberg
     * thing" direction and keeps search results from mixing in pages/attachments.
     * If a site needs global search later, we can toggle this via filter.
     */
    if ($query->is_search()) {
        $search_post_types = apply_filters('prelaunch_search_post_types', [ 'post' ]);
        $query->set('post_type', (array) $search_post_types);

        $per_page = (int) apply_filters('prelaunch_search_posts_per_page', 10);
        $query->set('posts_per_page', max(1, $per_page));

        return;
    }
}
add_action('pre_get_posts', 'prelaunch_blog_query_defaults');
