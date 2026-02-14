<?php
/**
 * Blog index (Posts page)
 *
 * Renders the main blog archive including:
 * - Sidebar filters (categories, tags, search)
 * - Post loop
 * - Pagination
 *
 * Notes:
 * - Filtering behavior is handled in queries.php (pre_get_posts).
 * - This file prepares selected filter state for the UI.
 *
 * Related:
 * - template-parts/blog/filters.php
 * - template-parts/blog/card.php
 * - queries.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-php
 * @link https://developer.wordpress.org/themes/basics/the-loop/
 */

get_header();

$posts_page_id = (int) get_option('page_for_posts');
$posts_page_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');
$page_title = $posts_page_id ? get_the_title($posts_page_id) : __('Blog', 'prelaunch-wp');

// Preserve Filter State
// STATE: Normalize selected filters from URL.
if (function_exists('prelaunch_parse_id_list')) {
    $selected_cats = prelaunch_parse_id_list(
        isset($_GET['pl_cat']) ? wp_unslash($_GET['pl_cat']) : []
    );

    $selected_tags = prelaunch_parse_id_list(
        isset($_GET['pl_tag']) ? wp_unslash($_GET['pl_tag']) : []
    );
} else {
    // Fallback (should not normally run).
    $parse_id_list = static function ($value): array {
        if (is_string($value)) {
            $value = preg_split('/\s*,\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
        }
        if (! is_array($value)) {
            return [];
        }
        return array_values(array_filter(array_map('absint', $value)));
    };

    $selected_cats = $parse_id_list(isset($_GET['pl_cat']) ? wp_unslash($_GET['pl_cat']) : []);
    $selected_tags = $parse_id_list(isset($_GET['pl_tag']) ? wp_unslash($_GET['pl_tag']) : []);
}

$search_query = get_search_query();

// Build "clear filters" URL (remove our filter params + search).
$clear_url = remove_query_arg([ 'pl_cat', 'pl_tag', 's', 'paged' ], $posts_page_url);

// Terms for the sidebar.
$categories = get_categories(
    [
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC',
    ]
);

$tags = get_tags(
    [
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC',
    ]
);
?>

	<main>
		<section class="section">
			<div class="py-10 wrap">

				<header class="mb-8">
					<h1 class="text-3xl font-semibold leading-tight">
						<?php echo esc_html($page_title); ?>
					</h1>
				</header>

				<div class="grid-12">
					<div class="col-span-12 mb-10 md:col-span-4">
						<?php get_template_part(
						    'template-parts/blog/filters',
						    null,
						    [
						        'posts_page_url' => $posts_page_url,
						        'categories' => $categories,
						        'tags' => $tags,
						        'selected_cats' => $selected_cats,
						        'selected_tags' => $selected_tags,
						        'search_query' => $search_query,
						        'clear_url' => $clear_url,
						    ]
						); ?>
					</div>

					<div class="col-span-12 md:col-span-8">

						<?php if (have_posts()) : ?>

							<div class="grid-12">
								<?php
						        while (have_posts()) :
						            the_post();
						            ?>
									<div class="col-span-12 md:col-span-6">
										<?php get_template_part('template-parts/blog/card'); ?>
									</div>
								<?php
						        endwhile;
						    ?>
							</div>

							<div class="mt-8">
								<?php
						    // Outputs pagination for the main query (helper should handle 1-page cases).
						    if (function_exists('prelaunch_pagination')) {
						        prelaunch_pagination();
						    } else {
						        the_posts_pagination();
						    }
?>
							</div>

						<?php else : ?>

							<p class="mt-2">
								<?php esc_html_e("We couldn't find any posts.", 'prelaunch-wp'); ?>
							</p>
						<?php endif; ?>

					</div>
				</div>
		</section>
	</main>

<?php
get_footer();
