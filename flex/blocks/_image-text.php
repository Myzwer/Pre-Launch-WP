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


	$content  = get_sub_field( 'content' );
	$image    = get_sub_field( 'image' );
	$image_id = ! empty( $image['ID'] ) ? absint( $image['ID'] ) : 0;

	if ( ! $content && ! $image_id ) {
		return;
	}
?>
<section class="py-10 wrap">
	<div class="grid-12">
		<div class="col-span-12">
			<?php
				if ( $image_id ) :
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						[
							'class' => 'rounded-lg shadow-lg mb-0',
						]
					);
				endif;
			?>
		</div>

		<div class="col-span-12">
			<?php if ( $content ) : ?>
				<div class="prose-theme"><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
