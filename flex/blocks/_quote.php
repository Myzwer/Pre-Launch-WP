<?php
	/**
	 * Quote / testimonial block.
	 *
	 * Renders a highlighted quote with attribution details.
	 *
	 * Used in:
	 * - testimonials
	 * - customer or member quotes
	 * - featured statements
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Quote content uses a WYSIWYG field for basic formatting such as italics.
	 * - Attribution may include title, company, or location.
	 * - Optional image may be displayed alongside the quote.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$intro       = get_sub_field( 'intro' );
	$quote       = get_sub_field( 'quote' );
	$image       = get_sub_field( 'image' );
	$image_id    = ! empty( $image['ID'] ) ? absint( $image['ID'] ) : 0;
	$name        = get_sub_field( 'name' );
	$attribution = get_sub_field( 'attribution' );
?>

<section class="wrap">
	<div class="py-8 grid-12 prose-theme">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="grid-12 prose-theme">
		<div class="col-span-12">
			<?php if ( $quote ) : ?>
				<blockquote><?php echo wp_kses_post( $quote ); ?></blockquote>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<?php if ( $image_id ) : ?>
				<div>
					<?php echo wp_get_attachment_image( $image_id, 'medium' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $name || $attribution ) : ?>
				<p>
					<?php if ( $name ) : ?>
						<strong><?php echo esc_html( $name ); ?></strong>
					<?php endif; ?>
					<?php if ( $name && $attribution ) : ?>
						<br>
					<?php endif; ?>
					<?php if ( $attribution ) : ?>
						<span><?php echo esc_html( $attribution ); ?></span>
					<?php endif; ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</section>
