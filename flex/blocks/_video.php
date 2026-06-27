<?php
	/**
	 * Video content block.
	 *
	 * Renders an embedded video with supporting text above and below.
	 *
	 * Used in:
	 * - promotional videos
	 * - tutorials or walkthroughs
	 * - sermon or media embeds
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Video is rendered via an oEmbed field.
	 * - Supporting text fields use WYSIWYG editors.
	 * - Headers should not use H1 to preserve page SEO structure.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	$intro   = get_sub_field( 'intro' );
	$video   = get_sub_field( 'video' );
	$content = get_sub_field( 'content' );
?>
<section class="py-10 wrap">
	<div class="grid-12">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div class="prose-theme">
					<?php echo wp_kses_post( $intro ); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<?php if ( $video ) : ?>
				<div class="video-container">
					<?php echo $video; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<?php if ( $content ) : ?>
				<div class="prose-theme">
					<?php echo wp_kses_post( $content ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
