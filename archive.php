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
