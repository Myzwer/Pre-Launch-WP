<?php
/**
 * Search results template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 * @link https://developer.wordpress.org/reference/functions/get_search_query/
 */

get_header();
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
                                esc_html__('Search results for: %s', 'prelaunch-wp'),
                                '<span class="font-normal">' . esc_html(get_search_query()) . '</span>'
                            );
?>
						</h1>

						<p class="mt-1 text-sm">
							<?php
global $wp_query;
$count = isset($wp_query->found_posts) ? (int) $wp_query->found_posts : 0;

printf(
    /* translators: %d: number of results. */
    esc_html(_n('%d result', '%d results', $count, 'prelaunch-wp')),
    $count
);
?>
						</p>
					</div>

					<div class="w-full sm:max-w-md">
						<?php get_search_form(); ?>
					</div>
				</div>

				<hr class="mt-6" />
			</header>

			<?php if (have_posts()) : ?>
				<div class="grid gap-6 md:grid-cols-2">
					<?php
                    while (have_posts()) :
                        the_post();
                        ?>
						<article <?php post_class('c-card c-card--post overflow-hidden rounded-xl border'); ?>>
							<div class="flex flex-col h-full">
								<?php if (has_post_thumbnail()) : ?>
									<a class="block c-card__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail('large', [ 'class' => 'h-auto w-full' ]); ?>
									</a>
								<?php endif; ?>

								<div class="flex flex-col flex-1 gap-3 p-5 c-card__body">
									<div class="flex flex-wrap gap-y-1 gap-x-3 items-center text-sm c-card__meta">
										<?php
                                        if (function_exists('prelaunch_posted_on')) {
                                            prelaunch_posted_on();
                                        }

                        if (function_exists('prelaunch_post_terms')) {
                            prelaunch_post_terms(
                                'category',
                                [
                                    'class' => 'post-terms post-terms--categories',
                                    'separator' => ', ',
                                ]
                            );
                        }
                        ?>
									</div>

									<h2 class="text-lg font-semibold leading-snug c-card__title">
										<a class="hover:underline underline-offset-4" href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</h2>

									<div class="text-sm leading-relaxed c-card__excerpt">
										<?php
                        if (function_exists('prelaunch_get_excerpt')) {
                            echo wp_kses_post(prelaunch_get_excerpt());
                        } else {
                            the_excerpt();
                        }
                        ?>
									</div>

									<div class="pt-2 mt-auto">
										<a class="text-sm hover:underline underline-offset-4" href="<?php the_permalink(); ?>">
											<?php esc_html_e('Read more', 'prelaunch-wp'); ?>
										</a>
									</div>
								</div>
							</div>
						</article>
					<?php
                    endwhile;
?>
				</div>

				<div class="flex justify-center mt-10">
					<?php
if (function_exists('prelaunch_pagination')) {
    prelaunch_pagination();
} else {
    the_posts_pagination();
}
?>
				</div>
			<?php else : ?>
				<div class="p-6 rounded-xl border">
					<p class="text-base font-medium">
						<?php esc_html_e('No results found.', 'prelaunch-wp'); ?>
					</p>
					<p class="mt-2 text-sm">
						<?php esc_html_e('Try a different search term, or browse recent posts.', 'prelaunch-wp'); ?>
					</p>

					<div class="mt-4 max-w-md">
						<?php get_search_form(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</main>

<?php
get_footer();
