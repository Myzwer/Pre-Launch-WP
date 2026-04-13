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


	$header = get_sub_field( 'header' );
	$intro  = get_sub_field( 'intro' );
?>
<section class="p-5 mx-auto max-w-screen-2xl xl:p-5 xl:w-8/12">
	<div class="grid grid-cols-12 gap-4 md:gap-4">
		<div class="col-span-12 py-5 max-w-none prose-theme">
			<?php if ( $header ) : ?>
				<h2><?php echo esc_html( $header ); ?></h2>
			<?php endif; ?>

			<?php if ( $intro ) : ?>
				<div><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>





