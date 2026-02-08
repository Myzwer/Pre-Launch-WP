<?php

/**
 * Blog post card component.
 *
 * Renders a single post preview card for use in:
 * - blog index
 * - archive views
 * - search results
 * - related posts
 *
 * Relies on the global $post context provided by the loop.
 *
 * Optional $args:
 * - variant (string) Card usage variant (e.g. 'blog', 'related').
 *   Defaults to 'blog' if not provided.
 *
 * Notes:
 * - Styling is controlled via `.card` base styles and variant classes.
 * - Markup is intentionally stable; visual changes should be handled in CSS.
 */
?>

<article class="card card--blog">
	<?php if (has_post_thumbnail()) : ?>
		<a class="card__media" href="<?php the_permalink(); ?>"
		   aria-label="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail('large', [ 'class' => 'h-auto w-full' ]); ?>
		</a>
	<?php endif; ?>

	<div class="card__body">
		<div class="card__meta">
			<?php
			echo prelaunch_display_date();

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
