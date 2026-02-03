<?php
/**
 * Single post template
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();
        ?>

		<article <?php post_class(); ?>>

			<?php if (has_post_thumbnail()) : ?>
				<header class="mb-10 w-full">
					<div class="overflow-hidden w-full aspect-video">
						<?php
                        the_post_thumbnail(
                            'full',
                            [
                                'class' => 'w-full h-full object-cover',
                                'loading' => 'eager',
                            ]
                        );
			    ?>
					</div>
				</header>
			<?php endif; ?>

			<div class="container px-4 mx-auto">
				<div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

					<div class="lg:col-span-8 lg:col-start-3">

						<header class="mb-8 space-y-3">
							<h1 class="text-3xl font-semibold">
								<?php the_title(); ?>
							</h1>

							<div class="space-y-1 text-sm">
								<div>
									<time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
										<?php echo esc_html(get_the_date()); ?>
									</time>
									<?php
			                $reading_time = prelaunch_get_reading_time(get_the_ID());
        if ($reading_time) :
            ?>
										<span aria-hidden="true"> · </span>
										<span><?php echo esc_html($reading_time); ?></span>
									<?php endif; ?>
								</div>

								<?php
                                $categories = get_the_category();
        if (!empty($categories)) :
            ?>
									<div>
										<span>Categories:</span>
										<?php
                foreach ($categories as $index => $category) {
                    if ($index > 0) {
                        echo ', ';
                    }
                    printf(
                        '<a href="%s">%s</a>',
                        esc_url(get_category_link($category)),
                        esc_html($category->name)
                    );
                }
            ?>
									</div>
								<?php endif; ?>

								<?php
                                $tags = get_the_tags();
        if ($tags) :
            ?>
									<div>
										<span>Tags:</span>
										<?php
                foreach ($tags as $index => $tag) {
                    if ($index > 0) {
                        echo ', ';
                    }
                    printf(
                        '<a href="%s">%s</a>',
                        esc_url(get_tag_link($tag)),
                        esc_html($tag->name)
                    );
                }
            ?>
									</div>
								<?php endif; ?>
							</div>
						</header>

						<div class="max-w-none">
							<?php the_content(); ?>
						</div>

						<?php
                        // Related posts (returns WP_Query)
                        $related_query = prelaunch_get_related_posts_query(get_the_ID(), [
                            'posts_per_page' => 4,
                        ]);

        if ($related_query && $related_query->have_posts()) :
            ?>
							<section class="mt-16">
								<h2 class="mb-6 text-xl font-semibold">
									Related Posts
								</h2>

								<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
									<?php
                    while ($related_query->have_posts()) :
                        $related_query->the_post();
                        ?>
										<article>
											<a href="<?php the_permalink(); ?>" class="block space-y-2">
												<?php if (has_post_thumbnail()) : ?>
													<div class="overflow-hidden aspect-video">
														<?php
                                        the_post_thumbnail(
                                            'medium',
                                            [
                                                'class' => 'w-full h-full object-cover',
                                            ]
                                        );
												    ?>
													</div>
												<?php endif; ?>

												<h3 class="font-medium">
													<?php the_title(); ?>
												</h3>

												<div class="text-sm">
													<?php echo esc_html(get_the_date()); ?>
												</div>
											</a>
										</article>
									<?php
                    endwhile;
            wp_reset_postdata();
            ?>
								</div>
							</section>
						<?php endif; ?>

					</div>

				</div>
			</div>

		</article>

	<?php
    endwhile;
endif;

get_footer();
