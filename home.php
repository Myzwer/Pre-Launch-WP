<?php
/**
 * Blog index template
 *
 * Used for the Posts page set in Settings → Reading.
 * Renders the main post loop and pagination.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-php
 * @link https://developer.wordpress.org/themes/basics/the-loop/
 */

get_header();

$posts_page_id = (int) get_option('page_for_posts');
$page_title = $posts_page_id ? get_the_title($posts_page_id) : __('Blog', 'prelaunch-wp');
?>

	<main class="site-main">
		<div class="py-10 px-4 mx-auto max-w-5xl">
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php echo esc_html($page_title); ?>
				</h1>
			</header>

			<?php if (have_posts()) : ?>
				<div class="grid gap-6 md:grid-cols-2">
					<?php
                    while (have_posts()) :
                        the_post();
                        ?>
						<article <?php post_class('c-card c-card--post'); ?>>
							<?php if (has_post_thumbnail()) : ?>
								<a class="c-card__media" href="<?php the_permalink(); ?>"
								   aria-label="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail('large'); ?>
								</a>
							<?php endif; ?>

							<div class="c-card__body">
								<div class="c-card__meta">
									<?php prelaunch_posted_on(); ?>
									<?php prelaunch_post_terms('category', [ 'class' => 'post-terms post-terms--categories',
                                                                              'separator' => ', ',
                                    ]); ?>
								</div>

								<h2 class="c-card__title">
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</h2>

								<span class="post-reading-time">
									<?php echo esc_html(prelaunch_get_reading_time()); ?>
								</span>

								<div class="c-card__excerpt">
									<?php echo wp_kses_post(prelaunch_get_excerpt()); ?>
								</div>
							</div>
						</article>
					<?php
                    endwhile;
			    ?>
				</div>

				<div class="mt-10">
					<?php prelaunch_pagination(); ?>
				</div>
			<?php else : ?>
				<p><?php esc_html_e('No posts found.', 'prelaunch-wp'); ?></p>
			<?php endif; ?>
		</div>
	</main>

<?php
get_footer();
