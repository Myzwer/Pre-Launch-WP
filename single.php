<?php
/**
 * Single post template
 */

get_header();
?>

	<main id="primary" class="site-main">
		<section class="section">
			<div class="wrap">

				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : ?>
						<?php the_post(); ?>

						<article <?php post_class(); ?>>

							<header class="mt-10 mb-8">
								<div class="mx-auto mb-3 text-center">

									<?php
                                    // Categories (each category is its own pill)
                                    $categories = get_the_category();
					    if (! empty($categories)) :
					        ?>
										<nav aria-label="<?php esc_attr_e('Post categories', 'prelaunch-wp'); ?>">
											<ul class="text-sm">
												<?php foreach ($categories as $category) : ?>
													<li class="inline-block mr-2 mb-2">
														<a
															class="inline-block py-1 px-3 text-black bg-gray-200 rounded-lg hover:shadow-md text-md"
															href="<?php echo esc_url(get_category_link($category)); ?>"
														>
															<?php echo esc_html($category->name); ?>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										</nav>
									<?php endif; ?>

									<?php
                                    // Tags (kept simple, no layout opinion; still separate from categories)
                                    $tags = get_the_tags();
					    if ($tags) :
					        ?>
										<nav class="pt-3 text-sm"
											 aria-label="<?php esc_attr_e('Post tags', 'prelaunch-wp'); ?>">
											<ul>
												<?php foreach ($tags as $index => $tag) : ?>
													<li class="inline-block">
														<?php if ($index > 0) : ?>
															<span aria-hidden="true">, </span>
														<?php endif; ?>
														<a href="<?php echo esc_url(get_tag_link($tag)); ?>">
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
                                    // Date (prefers helper if available)
                                    if (function_exists('prelaunch_display_date')) {
                                        echo wp_kses_post(prelaunch_display_date());
                                    } else {
                                        echo esc_html(get_the_date());
                                    }

					    // Reading time (helper returns string)
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
					            the_post_thumbnail(
					                'full',
					                [
					                    'class' => 'rounded-xl shadow-xl',
					                    'loading' => 'eager',
					                ]
					            );
									    ?>
										</figure>
									<?php endif; ?>
								</div>

								<section class="col-span-12 prose-theme"
										 aria-label="<?php esc_attr_e('Post content', 'prelaunch-wp'); ?>">
									<?php the_content(); ?>
								</section>

								<footer class="col-span-12 mb-10">
									<?php
                                    // Related posts (returns WP_Query)
                                    $related_query = function_exists('prelaunch_get_related_posts_query')
                                        ? prelaunch_get_related_posts_query(
                                            get_the_ID(),
                                            [
                                                'posts_per_page' => 4,
                                            ]
                                        )
                                        : null;

					    if ($related_query && $related_query->have_posts()) :
					        ?>
										<section class="mt-10"
												 aria-label="<?php esc_attr_e('Related posts', 'prelaunch-wp'); ?>">
											<h2 class="mb-6 text-xl font-semibold">
												<?php esc_html_e('Related Posts', 'prelaunch-wp'); ?>
											</h2>

											<div class="grid-12">
												<?php
					                while ($related_query->have_posts()) :
					                    $related_query->the_post();
					                    ?>
													<div class="col-span-12 md:col-span-6">
														<article class="card">
															<?php if (has_post_thumbnail()) : ?>
																<a
																	class="card__media"
																	href="<?php the_permalink(); ?>"
																	aria-label="<?php the_title_attribute(); ?>"
																>
																	<?php the_post_thumbnail('large', [ 'class' => 'h-auto w-full' ]); ?>
																</a>
															<?php endif; ?>

															<div class="card__body">
																<div class="card__meta">
																	<?php
					                                    $meta_parts = [];

					                    if (function_exists('prelaunch_display_date')) {
					                        $meta_parts[] = wp_strip_all_tags(prelaunch_display_date());
					                    } else {
					                        $meta_parts[] = get_the_date();
					                    }

					                    if (function_exists('prelaunch_get_reading_time')) {
					                        $rt = prelaunch_get_reading_time(get_the_ID());
					                        if ($rt) {
					                            $meta_parts[] = $rt;
					                        }
					                    }

					                    echo esc_html(implode(' · ', array_filter($meta_parts)));

					                    if (function_exists('prelaunch_post_terms')) {
					                        echo ' · ';
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

																<h3 class="card__title">
																	<a href="<?php the_permalink(); ?>">
																		<?php the_title(); ?>
																	</a>
																</h3>

																<div class="card__content">
																	<?php
					                    echo wp_kses_post(
					                        function_exists('prelaunch_get_excerpt')
					                            ? prelaunch_get_excerpt()
					                            : get_the_excerpt()
					                    );
					                    ?>
																</div>

																<div>
																	<a class="card__cta"
																	   href="<?php the_permalink(); ?>">
																		<?php esc_html_e('Read more', 'prelaunch-wp'); ?>
																	</a>
																</div>
															</div>
														</article>
													</div>
												<?php
					                endwhile;

					    wp_reset_postdata();
					    ?>
											</div>
										</section>
									<?php endif; ?>
								</footer>
							</div>

						</article>

					<?php endwhile; ?>
				<?php endif; ?>

			</div>
		</section>
	</main>

<?php
get_footer();
