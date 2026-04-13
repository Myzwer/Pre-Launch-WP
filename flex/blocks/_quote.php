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


	$header      = get_sub_field( 'header' );
	$quote       = get_sub_field( 'quote' );
	$image       = get_sub_field( 'image' );
	$name        = get_sub_field( 'name' );
	$attribution = get_sub_field( 'attribution' );
?>
<section class="flex-block flex-block--quote">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $quote ) : ?>
		<blockquote><?php echo wp_kses_post( $quote ); ?></blockquote>
	<?php endif; ?>

	<?php if ( ! empty( $image['ID'] ) ) : ?>
		<div>
			<?php echo wp_get_attachment_image( (int) $image['ID'], 'medium' ); ?>
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
</section>
