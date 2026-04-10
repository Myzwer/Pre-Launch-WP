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
$content = get_sub_field( 'content' );
$link    = get_sub_field( 'link' );
?>
<section class="flex-block flex-block--info">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $content ) : ?>
		<div><?php echo wp_kses_post( $content ); ?></div>
	<?php endif; ?>

	<?php if ( ! empty( $link['url'] ) ) : ?>
		<p>
			<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></a>
		</p>
	<?php endif; ?>

	<?php if ( have_rows( 'items' ) ) : ?>
		<div>
			<?php while ( have_rows( 'items' ) ) : the_row(); ?>
				<article>
					<?php $title = get_sub_field( 'item_title' ); ?>
					<?php $text = get_sub_field( 'item_text' ); ?>
					<?php if ( $title ) : ?>
						<h3><?php echo esc_html( $title ); ?></h3>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p><?php echo nl2br( esc_html( $text ) ); ?></p>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</section>
