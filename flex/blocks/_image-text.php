<?php
	/**
	 * Image + text content block.
	 *
	 * Renders a section combining an image with accompanying text content.
	 *
	 * Used in:
	 * - feature explanations
	 * - service highlights
	 * - visual storytelling sections
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Image should be optimized and ideally landscape orientation.
	 * - Text content is rendered from a WYSIWYG field.
	 * - Block should return early if no meaningful content exists.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$header = get_sub_field( 'header' );
	$intro  = get_sub_field( 'intro' );
	$image  = get_sub_field( 'image' );
?>
<section class="flex-block flex-block--image-text">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $intro ) : ?>
		<div><?php echo wp_kses_post( $intro ); ?></div>
	<?php endif; ?>

	<?php if ( ! empty( $image['ID'] ) ) : ?>
		<div>
			<?php echo wp_get_attachment_image( (int) $image['ID'], 'large' ); ?>
		</div>
	<?php endif; ?>
</section>
