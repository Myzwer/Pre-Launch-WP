<?php
	/**
	 * Text content block.
	 *
	 * Renders a standard text section with a header and WYSIWYG intro.
	 *
	 * Used in:
	 * - general page content
	 * - simple informational sections
	 * - lightweight copy blocks
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Intro field uses a WYSIWYG editor and should render inside `.prose-theme`.
	 * - Headers should be limited to H2–H6 to preserve page hierarchy.
	 * - Block should return early if both header and intro are empty.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	$content = get_sub_field( 'content' );
?>

<section class="wrap">
	<div class="py-8 grid-12 prose-theme">
		<div class="col-span-12">
			<?php if ( $content ) : ?>
				<div class="">
					<?php echo wp_kses_post( $content ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>





