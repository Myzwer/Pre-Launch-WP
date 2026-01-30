<?php

/**
 * Posts / content helpers
 *
 * Shared utilities used by the blog (and reusable by future CPT archives/directories):
 * - Excerpt defaults
 * - Pagination output
 *
 * @link https://developer.wordpress.org/reference/hooks/excerpt_length/
 * @link https://developer.wordpress.org/reference/functions/paginate_links/
 */

/**
 * Set the default excerpt length (in words).
 *
 * Override per-site via the `prelaunch_excerpt_length` filter.
 *
 * @param int $length Default excerpt length.
 * @return int
 */
function prelaunch_excerpt_length($length)
{
    /**
     * Filter the theme's default excerpt length.
     *
     * @param int $length Excerpt length in words.
     */
    $length = (int) apply_filters('prelaunch_excerpt_length', 24);

    // WordPress expects a positive integer.
    return max(1, $length);
}
add_filter('excerpt_length', 'prelaunch_excerpt_length', 999);

/**
 * Output pagination links for a query (main query or custom WP_Query).
 *
 * Use this on:
 * - Blog index
 * - Archives (category/tag/date)
 * - Search results
 * - Any custom paged WP_Query loop (pass the query object)
 *
 * @param WP_Query|null $query Query to paginate. Defaults to global $wp_query.
 * @param array         $args  Optional args passed to paginate_links().
 * @return void
 */
function prelaunch_pagination($query = null, $args = [])
{
    // No pagination UI on singular views (single posts/pages).
    if (is_singular()) {
        return;
    }

    // Default to the main query.
    if (! $query) {
        global $wp_query;
        $query = $wp_query;
    }

    // Bail if the query isn't valid or has only one page.
    if (! ($query instanceof WP_Query) || (int) $query->max_num_pages <= 1) {
        return;
    }

    $current = get_query_var('paged') ? absint(get_query_var('paged')) : 1;

    $defaults = [
        'total' => (int) $query->max_num_pages,
        'current' => $current,
        'mid_size' => 2,
        'end_size' => 1,
        'prev_text' => __('Previous', 'prelaunch-wp'),
        'next_text' => __('Next', 'prelaunch-wp'),
        'type' => 'list', // outputs <ul class="page-numbers">…</ul>
    ];

    $links = paginate_links(array_merge($defaults, $args));

    if (empty($links)) {
        return;
    }

    echo '<nav class="pagination" aria-label="' . esc_attr__('Posts', 'prelaunch-wp') . '">';
    echo $links; // paginate_links() returns safe URLs
    echo '</nav>';
}
