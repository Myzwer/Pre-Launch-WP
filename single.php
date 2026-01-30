<?php
/**
 * Single post template
 *
 * Renders a single blog post. Intended for Gutenberg-edited post content.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @link https://developer.wordpress.org/themes/basics/the-loop/
 */

get_header();

$posts_page_id = (int) get_option('page_for_posts');
$posts_page_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');
$posts_page_txt = $posts_page_id ? get_the_title($posts_page_id) : __('Blog', 'prelaunch-wp');
?>

	<main class="site-main">
		<div class="container">
			<?php if (have_posts()) : ?>
				<?php
                while (have_posts()) :
                    the_post();
                    ?>
					<article <?php post_class('post'); ?>>
						<header class="post-header">
							<h1 class="post-title"><?php the_title(); ?></h1>

							<div class="post-meta">
								<?php
                                // Date (and modified date if different).
                                if (function_exists('prelaunch_posted_on')) {
                                    prelaunch_posted_on();
                                } else {
                                    echo '<time datetime="' . esc_attr(get_the_date(DATE_W3C)) . '">';
                                    echo esc_html(get_the_date());
                                    echo '</time>';
                                }

                    // Categories (optional to style/show).
                    if (function_exists('prelaunch_post_terms')) {
                        prelaunch_post_terms('category', [ 'class' => 'post-terms post-terms--categories', 'separator' => ', ' ]);
                    }
                    ?>
							</div>
						</header>

						<div class="post-content prose-theme">
							<?php
                            the_content();

                    // Support for multi-page posts if someone uses <!--nextpage-->.
                    wp_link_pages(
                        [
                            'before' => '<nav class="post-pages" aria-label="' . esc_attr__('Post pages', 'prelaunch-wp') . '">',
                            'after' => '</nav>',
                        ]
                    );
                    ?>
						</div>

						<footer class="post-footer">
							<?php
                    // Tags (optional).
                    if (function_exists('prelaunch_post_terms')) {
                        prelaunch_post_terms('post_tag', [ 'class' => 'post-terms post-terms--tags', 'separator' => ', ' ]);
                    }
                    ?>
						</footer>

						<?php if (function_exists('prelaunch_related_posts')) : ?>
							<?php prelaunch_related_posts(); ?>
						<?php endif; ?>

					</article>
				<?php
                endwhile;
?>
			<?php else : ?>
				<p><?php esc_html_e('Post not found.', 'prelaunch-wp'); ?></p>
			<?php endif; ?>
		</div>
	</main>

<?php
get_footer();
