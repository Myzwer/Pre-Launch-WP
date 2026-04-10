<?php
/**
 * Flex block partial.
 *
 * Barebones output for verifying ACF content rendering.
 * No styling included.
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
