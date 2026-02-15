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

if (! function_exists('prelaunch_excerpt_length')) {
    /**
     * Set the default excerpt length (in words).
     *
     * Override per-site via the `prelaunch_excerpt_length` filter.
     *
     * @param int $length Default excerpt length.
     * @return int
     */
    function prelaunch_excerpt_length(int $length): int
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
}
add_filter('excerpt_length', 'prelaunch_excerpt_length', 999);

if (! function_exists('prelaunch_pagination')) {
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
    function prelaunch_pagination(?WP_Query $query = null, array $args = []): void
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

            // Swap text for FA icons (+ screen reader text)
            'prev_text' => '<span class="sr-only">' . esc_html__('Previous', 'prelaunch-wp') . '</span><i class="fa-solid fa-angle-left" aria-hidden="true"></i>',
            'next_text' => '<span class="sr-only">' . esc_html__('Next', 'prelaunch-wp') . '</span><i class="fa-solid fa-angle-right" aria-hidden="true"></i>',

            'type' => 'list',

            // Optional override for aria-label.
            'aria_label' => esc_attr__('Posts', 'prelaunch-wp'),
        ];

        $config = array_merge($defaults, $args);

        $links = paginate_links($config);

        if (empty($links)) {
            return;
        }

        echo '<nav class="pagination" aria-label="' . esc_attr($config['aria_label']) . '">';
        echo $links; // paginate_links() returns safe URLs.
        echo '</nav>';
    }
}
