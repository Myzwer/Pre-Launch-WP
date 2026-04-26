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


	$content = get_sub_field( 'content' );
	$image   = get_sub_field( 'image' );
?>
<section class="py-5 wrap">
	<div class="grid-12 prose-theme">
		<div class="col-span-12">
			<?php if ( ! empty( $image['ID'] ) ) :
				echo wp_get_attachment_image(
					(int) $image['ID'],
					'large',
					false,
					[
						'class' => 'rounded-lg shadow-lg mb-0'
					]
				);
			endif; ?>
		</div>

		<div class="col-span-12">
			<?php if ( $content ) : ?>
				<div><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
