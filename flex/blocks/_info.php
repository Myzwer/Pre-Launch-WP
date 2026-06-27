<?php
	/**
	 * Information block.
	 *
	 * Renders structured informational content with optional supporting items.
	 *
	 * Used in:
	 * - structured copywriting layouts
	 * - educational or explanatory content
	 * - long-form informational pages
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Header is stored in a text field.
	 * - Main content is rendered from a WYSIWYG field.
	 * - Supporting items are generated from a repeater field.
	 * - Layout may gracefully degrade if some fields are unused.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$header  = get_sub_field( 'header' );
	$content = get_sub_field( 'content' );
	$link    = get_sub_field( 'link' );
?>

<section class="py-10 wrap">
	<?php if ( $header ) : ?>
		<div class="pb-10 grid-12">
			<div class="col-span-12 mx-auto text-center">
				<h2 class="heading-2"><?php echo esc_html( $header ); ?></h2>
			</div>
		</div>
	<?php endif; ?>

	<div class="md:gap-8 grid-12">
		<div class="col-span-12 md:col-span-6">
			<?php if ( $content ) : ?>
				<div class="prose-theme">
					<?php echo wp_kses_post( $content ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $link['url'] ) ) : ?>
				<div class="mt-8">
					<a
						class="btn_main"
						href="<?php echo esc_url( $link['url'] ); ?>"
						<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
					>
						<span><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></span>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<div class="col-span-12 md:col-span-6">
			<div class="gap-y-8 md:gap-y-10 grid-12">
				<?php if ( have_rows( 'items' ) ) : ?>
					<?php while ( have_rows( 'items' ) ) : the_row(); ?>
						<?php $title = get_sub_field( 'item_title' ); ?>
						<?php $text = get_sub_field( 'item_text' ); ?>

						<article class="col-span-12">
							<div class="prose-theme prose-compact">
								<?php if ( $title ) : ?>
									<h4><?php echo esc_html( $title ); ?></h4>
								<?php endif; ?>

								<?php if ( $text ) : ?>
									<p><?php echo nl2br( esc_html( $text ) ); ?></p>
								<?php endif; ?>
							</div>
						</article>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
