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


$message = get_sub_field( 'message' );
$link    = get_sub_field( 'link' );
?>
<section class="flex-block flex-block--quick-cta">
	<?php if ( $message ) : ?>
		<p><?php echo nl2br( esc_html( $message ) ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $link['url'] ) ) : ?>
		<p>
			<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></a>
		</p>
	<?php endif; ?>
</section>
