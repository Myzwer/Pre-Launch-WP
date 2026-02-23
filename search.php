<?php
/**
 * Search results template.
 *
 * Related:
 * - template-parts/blog/card.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 * @link https://developer.wordpress.org/reference/functions/get_search_query/
 */

get_header();

global $wp_query;
$count = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
?>

<main class="site-main">
	<div class="py-10 px-4 mx-auto max-w-5xl">
		<header class="mb-8">
			<div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-end">
				<div>
					<h1 class="text-2xl font-semibold leading-tight">
						<?php
						printf(
						/* translators: %s: Search query. */
							esc_html__( 'Search results for: %s', 'prelaunch-wp' ),
							'<span class="font-normal">' . esc_html( get_search_query() ) . '</span>'
						);
						?>
					</h1>

					<p class="mt-1 text-sm">
						<?php
						printf(
						/* translators: %d: number of results. */
							esc_html( _n( '%d result', '%d results', $count, 'prelaunch-wp' ) ),
							$count
						);
						?>
					</p>
				</div>

				<div class="w-full sm:max-w-md">
					<?php get_search_form(); ?>
				</div>
			</div>

			<hr class="mt-6"/>
		</header>

		<?php if( have_posts() ) : ?>
			<div class="grid-12">
				<?php while( have_posts() ) : ?>
					<?php the_post(); ?>

					<div class="col-span-12 md:col-span-6">
						<?php get_template_part( 'template-parts/blog/card' ); ?>
					</div>
				<?php endwhile; ?>
			</div>

			<div class="flex justify-center mt-10">
				<?php
				if( function_exists( 'prelaunch_pagination' ) ) {
					prelaunch_pagination();
				} else {
					the_posts_pagination();
				}
				?>
			</div>
		<?php else : ?>
			<div class="p-6 rounded-xl border">
				<p class="text-base font-medium">
					<?php esc_html_e( 'No results found.', 'prelaunch-wp' ); ?>
				</p>
				<p class="mt-2 text-sm">
					<?php esc_html_e( 'Try a different search term, or browse recent posts.', 'prelaunch-wp' ); ?>
				</p>

				<div class="mt-4 max-w-md">
					<?php get_search_form(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
