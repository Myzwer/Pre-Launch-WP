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


	$header  = get_sub_field( 'header' );
	$intro   = get_sub_field( 'intro' );
	$video   = get_sub_field( 'video' );
	$content = get_sub_field( 'content' );
?>
<section class="flex-block flex-block--video">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $intro ) : ?>
		<div><?php echo wp_kses_post( $intro ); ?></div>
	<?php endif; ?>

	<?php if ( $video ) : ?>
		<div>
			<?php echo wp_kses_post( wp_oembed_get( $video ) ?: $video ); ?>
		</div>
	<?php endif; ?>

	<?php if ( $content ) : ?>
		<div><?php echo wp_kses_post( $content ); ?></div>
	<?php endif; ?>
</section>
