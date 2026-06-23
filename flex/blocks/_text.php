<?php
	/**
	 * Text content block.
	 *
	 * Renders a standard text section with WYSIWYG content.
	 *
	 * Used in:
	 * - general page content
	 * - simple informational sections
	 * - lightweight copy blocks
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Content field uses a WYSIWYG editor and should render inside `.prose-theme`.
	 * - Headers should be limited to H2–H6 to preserve page hierarchy.
	 * - Block should return early if content is empty.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	$content = get_sub_field( 'content' );
?>

<section class="wrap">
	<div class="py-10 grid-12">
		<div class="col-span-12">
			<?php if ( $content ) : ?>
				<div class="prose-theme">
					<?php echo wp_kses_post( $content ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
