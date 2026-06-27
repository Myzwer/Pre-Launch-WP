<?php
	/**
	 * Card grid content block.
	 *
	 * Renders a repeating set of cards containing a title and text, with an optional block-level link.
	 *
	 * Used in:
	 * - services grids
	 * - feature highlights
	 * - content summaries
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Cards are generated from a repeater field.
	 * - Descriptions use a textarea field for simple copy.
	 * - Optional button may appear after the grid.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$intro = get_sub_field( 'intro' );
	$link  = get_sub_field( 'link' );
?>

<section class="wrap">
	<div class="py-10 grid-12">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div class="pb-5 prose-theme"><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<div class="grid-12">
				<?php if ( have_rows( 'cards' ) ) : ?>

					<?php while ( have_rows( 'cards' ) ) : the_row(); ?>
						<?php $title = get_sub_field( 'card_title' ); ?>
						<?php $text = get_sub_field( 'card_text' ); ?>

						<article class="col-span-12 p-5 mb-5 bg-white rounded-lg shadow-lg">
							<?php if ( $title ) : ?>
								<h4 class="heading-4"><?php echo esc_html( $title ); ?></h4>
							<?php endif; ?>

							<?php if ( $text ) : ?>
								<p><?php echo nl2br( esc_html( $text ) ); ?></p>
							<?php endif; ?>
						</article>
					<?php endwhile; ?>

				<?php endif; ?>
			</div>
		</div>

		<div class="col-span-12">
			<div class="grid-12">
				<?php if ( ! empty( $link['url'] ) ) : ?>
					<div class="col-span-12 mx-auto text-center">
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
		</div>
	</div>
</section>
