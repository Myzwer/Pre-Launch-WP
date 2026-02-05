<?php
/**
 * Archive template.
 *
 * Generic archive view for categories, tags, dates, authors, and other archives.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#archive
 * @link https://developer.wordpress.org/reference/functions/the_archive_title/
 * @link https://developer.wordpress.org/reference/functions/the_archive_description/
 */

get_header();
?>

	<main class="site-main">
		<div class="py-10 px-4 mx-auto max-w-5xl">
			<header class="mb-8">
				<h1 class="text-2xl font-semibold leading-tight">
					<?php the_archive_title(); ?>
				</h1>

				<?php if (get_the_archive_description()) : ?>
					<div class="mt-2 text-sm leading-relaxed">
						<?php the_archive_description(); ?>
					</div>
				<?php endif; ?>

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
                            // Categories make sense on most post archives; harmless elsewhere.
                            prelaunch_post_terms(
                                'category',
                                [
                                    'class' => 'post-terms post-terms--categories',
                                    'separator' => ', ',
                                ]
                            );
                        }
                        if (function_exists('prelaunch_get_reading_time')) {
                            echo '<span class="post-reading-time">' . esc_html(prelaunch_get_reading_time()) . '</span>';
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
						<?php esc_html_e('Nothing found.', 'prelaunch-wp'); ?>
					</p>
					<p class="mt-2 text-sm">
						<?php esc_html_e('Try browsing another archive or searching for something else.', 'prelaunch-wp'); ?>
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
