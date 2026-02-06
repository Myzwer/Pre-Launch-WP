<?php
/**
 * Blog index template (Posts page).
 *
 * Renders a filter sidebar (search + taxonomy filters) and a post list.
 * Filters submit via GET and are applied to the main query in includes/posts/queries.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-php
 * @link https://developer.wordpress.org/themes/basics/the-loop/
 */

get_header();

$posts_page_id = (int) get_option('page_for_posts');
$posts_page_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');
$page_title = $posts_page_id ? get_the_title($posts_page_id) : __('Blog', 'prelaunch-wp');

// Preserve filter state.
$raw_cats = isset($_GET['pl_cat']) ? (array) wp_unslash($_GET['pl_cat']) : [];
$raw_tags = isset($_GET['pl_tag']) ? (array) wp_unslash($_GET['pl_tag']) : [];

$selected_cats = array_values(array_filter(array_map('absint', $raw_cats)));
$selected_tags = array_values(array_filter(array_map('absint', $raw_tags)));

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

	<main class="site-main">
		<section class="section">
			<div class="py-10 wrap">

				<header class="mb-8">
					<h1 class="text-3xl font-semibold leading-tight">
						<?php echo esc_html($page_title); ?>
					</h1>
				</header>

				<div class="grid-12">
					<div class="col-span-4">
						<aside class = "card">
							<div class="card__body">
								<form method="get" action="<?php echo esc_url($posts_page_url); ?>" class="grid gap-6">
									<div class="grid gap-2">
										<label class="text-sm font-semibold" for="pl-search">
											<?php esc_html_e('Search', 'prelaunch-wp'); ?>
										</label>
										<input
											id="pl-search"
											type="search"
											name="s"
											value="<?php echo esc_attr($search_query); ?>"
											class="py-2 px-3 w-full rounded-lg border"
											placeholder="<?php echo esc_attr_x('Search posts…', 'placeholder', 'prelaunch-wp'); ?>"
										/>
									</div>

									<?php if (! empty($categories)) : ?>
										<fieldset class="grid gap-3">
											<legend class="text-sm font-semibold">
												<?php esc_html_e('Categories', 'prelaunch-wp'); ?>
											</legend>

											<div class="grid gap-2">
												<?php foreach ($categories as $cat) : ?>
													<label class="grid gap-2 items-start text-sm grid-cols-[auto_1fr]">
														<input
															type="checkbox"
															name="pl_cat[]"
															value="<?php echo esc_attr((int) $cat->term_id); ?>"
															<?php checked(in_array((int) $cat->term_id, $selected_cats, true)); ?>
															class="mt-1"
														/>
														<span>
													<?php echo esc_html($cat->name); ?>
												</span>
													</label>
												<?php endforeach; ?>
											</div>
										</fieldset>
									<?php endif; ?>

									<?php if (! empty($tags)) : ?>
										<fieldset class="grid gap-3">
											<legend class="text-sm font-semibold">
												<?php esc_html_e('Tags', 'prelaunch-wp'); ?>
											</legend>

											<div class="grid gap-2">
												<?php foreach ($tags as $tag) : ?>
													<label class="grid gap-2 items-start text-sm grid-cols-[auto_1fr]">
														<input
															type="checkbox"
															name="pl_tag[]"
															value="<?php echo esc_attr((int) $tag->term_id); ?>"
															<?php checked(in_array((int) $tag->term_id, $selected_tags, true)); ?>
															class="mt-1"
														/>
														<span>
													<?php echo esc_html($tag->name); ?>
												</span>
													</label>
												<?php endforeach; ?>
											</div>
										</fieldset>
									<?php endif; ?>

									<div class="grid gap-3">
										<button type="submit" class="justify-center w-full cursor-pointer btn_main">
											<?php esc_html_e('Apply filters', 'prelaunch-wp'); ?>
										</button>

										<a class="justify-center w-full text-center btn_ghost_black" href="<?php echo esc_url($clear_url); ?>">
											<?php esc_html_e('Clear', 'prelaunch-wp'); ?>
										</a>
									</div>
								</form>
							</div>
						</aside>
					</div>


					<div class="col-span-8">
						<div class="grid-12">
							<?php if (have_posts()) :
							    while (have_posts()) :
							        the_post();
							        ?>
									<div class="col-span-6">
										<article class="card card--blog">
											<?php if (has_post_thumbnail()) : ?>
												<a class="card--media" href="<?php the_permalink(); ?>"
												   aria-label="<?php the_title_attribute(); ?>">
													<?php the_post_thumbnail('large', [ 'class' => 'h-auto w-full' ]); ?>
												</a>
											<?php endif; ?>

											<div class="card__body">
												<div class="card__meta">
													<?php
							                        if (function_exists('prelaunch_posted_on')) {
							                            prelaunch_posted_on();
							                        }

							        echo ' - ';

							        if (function_exists('prelaunch_get_reading_time')) {
							            echo '<span class="post-reading-time">' . esc_html(prelaunch_get_reading_time()) . '</span>';
							        }

							        echo ' - ';

							        if (function_exists('prelaunch_post_terms')) {
							            prelaunch_post_terms('category', [ 'class' => 'post-terms post-terms--categories', 'separator' => ', ' ]);
							        }
							        ?>
												</div>

												<h2 class="card__title">
													<a href="<?php the_permalink(); ?>">
														<?php the_title(); ?>
													</a>
												</h2>

												<div class="card__content">
													<?php echo wp_kses_post(function_exists('prelaunch_get_excerpt') ? prelaunch_get_excerpt() : get_the_excerpt()); ?>
												</div>

												<div class="">
													<a class = "card__cta" href="<?php the_permalink(); ?>">
														<?php esc_html_e('Read more', 'prelaunch-wp'); ?>
													</a>
												</div>
										</article>

									</div>
								<?php
							    endwhile;
							endif;
?>
						</div>


					</div>
				</div>

			</div>
		</section>
	</main>

<?php
get_footer();
