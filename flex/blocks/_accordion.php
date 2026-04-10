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


$header = get_sub_field( 'header' );
$intro  = get_sub_field( 'intro' );
?>
<section class="flex-block flex-block--accordion">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $intro ) : ?>
		<div><?php echo wp_kses_post( $intro ); ?></div>
	<?php endif; ?>

	<?php if ( have_rows( 'accordion_items' ) ) : ?>
		<div>
			<?php while ( have_rows( 'accordion_items' ) ) : the_row(); ?>
				<details>
					<?php $title = get_sub_field( 'accordion_title' ); ?>
					<?php $content = get_sub_field( 'accordion_content' ); ?>
					<?php if ( $title ) : ?>
						<summary><?php echo esc_html( $title ); ?></summary>
					<?php endif; ?>
					<?php if ( $content ) : ?>
						<div><?php echo wp_kses_post( $content ); ?></div>
					<?php endif; ?>
				</details>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</section>
