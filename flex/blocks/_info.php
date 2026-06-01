<?php
	/**
	 * Information block.
	 *
	 * Renders structured informational content organized into sections.
	 *
	 * Used in:
	 * - structured copywriting layouts
	 * - educational or explanatory content
	 * - long-form informational pages
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Structure may include repeatable headings and supporting text.
	 * - Designed to support structured copywriting formats.
	 * - Layout may gracefully degrade if some fields are unused.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$header  = get_sub_field( 'header' );
	$content = get_sub_field( 'content' );
	$link    = get_sub_field( 'link' );
?>

<section class="wrap">
	<div class="pt-8 grid-12 prose-theme">
		<div class="col-span-12 mx-auto text-center">
			<?php if ( $header ) : ?>
				<h2><?php echo esc_html( $header ); ?></h2>
			<?php endif; ?>
		</div>
	</div>

	<div class="py-8 grid-12 prose-theme">
		<div class="col-span-12 md:col-span-6">
			<?php if ( $content ) : ?>
				<div><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>


			<?php if ( ! empty( $link['url'] ) ) : ?>
			<div class="col-span-12">
				<a
					class="btn_main"
					href="<?php echo esc_url( $link['url'] ); ?>"
					<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
				>
					<span><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></span>
				</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="col-span-12 md:col-span-6">
			<div class="grid-12">
				<?php if ( have_rows( 'items' ) ) : ?>

					<?php while ( have_rows( 'items' ) ) : the_row(); ?>
						<div class="col-span-12">
							<?php $title = get_sub_field( 'item_title' ); ?>
							<?php $text = get_sub_field( 'item_text' ); ?>
							<?php if ( $title ) : ?>
								<h3 class="mt-0"><?php echo esc_html( $title ); ?></h3>
							<?php endif; ?>
							<?php if ( $text ) : ?>
								<p><?php echo nl2br( esc_html( $text ) ); ?></p>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

