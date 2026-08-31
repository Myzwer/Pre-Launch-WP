<?php
/**
 * Single post template
 *
 * Renders a single blog post with:
 * - Categories + tags
 * - Title + date + reading time
 * - Featured image
 * - Content
 * - Related posts
 *
 * Related:
 * - template-parts/blog/card.php
 * - template-tags.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header();
?>

<main id="main-content" class="site-main">
	<section class="section">
		<div class="wrap">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : ?>
					<?php the_post(); ?>

					<article <?php post_class(); ?>>
						<header class="mt-10 mb-8">
							<div class="mx-auto mb-3 text-center">
								<?php
                                // OUTPUT: Categories (each category is its own pill).
                                $categories = get_the_category();
				    ?>

								<?php if (! empty($categories)) : ?>
									<nav aria-label="<?php esc_attr_e('Post categories', 'prelaunch-wp'); ?>">
										<ul class="text-sm">
											<?php foreach ($categories as $category) : ?>
												<li class="inline-block mr-2 mb-2">
													<a
														class="inline-block py-1 px-3 text-black bg-gray-200 rounded-lg hover:shadow-md text-md"
														href="<?php echo esc_url(get_category_link((int) $category->term_id)); ?>"
													>
														<?php echo esc_html($category->name); ?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									</nav>
								<?php endif; ?>

								<?php
				    // OUTPUT: Tags (kept simple; separate from categories).
				    $tags = get_the_tags();
				    ?>

								<?php if (! empty($tags)) : ?>
									<nav class="pt-3 text-sm" aria-label="<?php esc_attr_e('Post tags', 'prelaunch-wp'); ?>">
										<ul>
											<?php foreach ($tags as $index => $tag) : ?>
												<li class="inline-block">
													<?php if ($index > 0) : ?>
														<span aria-hidden="true">, </span>
													<?php endif; ?>

													<a href="<?php echo esc_url(get_tag_link((int) $tag->term_id)); ?>">
														<?php echo esc_html($tag->name); ?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									</nav>
								<?php endif; ?>
							</div>

							<h1 class="text-3xl font-semibold text-center">
								<?php the_title(); ?>
							</h1>

							<p class="mx-auto mt-2 text-center">
								<?php
				    // OUTPUT: Date (prefers helper if available).
				    if (function_exists('prelaunch_display_date')) {
				        echo wp_kses_post(prelaunch_display_date());
				    } else {
				        echo esc_html(get_the_date());
				    }

				    // OUTPUT: Reading time.
				    $reading_time = function_exists('prelaunch_get_reading_time')
				        ? prelaunch_get_reading_time(get_the_ID())
				        : '';

				    if ($reading_time) :
				        ?>
									<span aria-hidden="true"> · </span>
									<span><?php echo esc_html($reading_time); ?></span>
								<?php endif; ?>
							</p>
						</header>

						<div class="grid-12">
							<div class="col-span-12">
								<?php if (has_post_thumbnail()) : ?>
									<figure class="mb-8">
										<?php
				            the_post_thumbnail('full', [
				                'class' => 'rounded-xl shadow-xl',
				                'loading' => 'eager',
				            ]);
								    ?>
									</figure>
								<?php endif; ?>
							</div>

							<section class="col-span-12 prose-theme" aria-label="<?php esc_attr_e('Post content', 'prelaunch-wp'); ?>">
								<?php the_content(); ?>
							</section>

							<footer class="col-span-12 mb-10">
								<?php
                                // QUERY: Related posts (helper returns WP_Query).
                                $related_query = function_exists('prelaunch_get_related_posts_query')
                                    ? prelaunch_get_related_posts_query(get_the_ID(), [
								    'posts_per_page' => 4,
                                    ])
                                    : null;
				    ?>

								<?php if ($related_query && $related_query->have_posts()) : ?>
									<section class="mt-10" aria-label="<?php esc_attr_e('Related posts', 'prelaunch-wp'); ?>">
										<h2 class="mb-6 text-xl font-semibold">
											<?php esc_html_e('Related Posts', 'prelaunch-wp'); ?>
										</h2>

										<div class="grid-12">
											<?php while ($related_query->have_posts()) : ?>
												<?php $related_query->the_post(); ?>

												<div class="col-span-12 md:col-span-6">
													<?php get_template_part('template-parts/blog/card'); ?>
												</div>
											<?php endwhile; ?>
										</div>
									</section>

									<?php wp_reset_postdata(); ?>
								<?php endif; ?>
							</footer>
						</div>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<div class="p-6 rounded-xl border">
					<p class="text-base font-medium">
						<?php esc_html_e('Nothing found.', 'prelaunch-wp'); ?>
					</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
