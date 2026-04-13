<?php
	/**
	 * Card grid content block.
	 *
	 * Renders a repeating set of cards containing a title, text, and optional link.
	 *
	 * Used in:
	 * - services grids
	 * - feature highlights
	 * - content summaries
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Cards are generated from a repeater field.
	 * - Descriptions use a textarea field for simple copy.
	 * - Optional button may appear after the grid.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$header = get_sub_field( 'header' );
	$intro  = get_sub_field( 'intro' );
	$link   = get_sub_field( 'link' );
?>
<section class="flex-block flex-block--cards">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $intro ) : ?>
		<div><?php echo wp_kses_post( $intro ); ?></div>
	<?php endif; ?>

	<?php if ( have_rows( 'cards' ) ) : ?>
		<div>
			<?php while ( have_rows( 'cards' ) ) : the_row(); ?>
				<article>
					<?php $title = get_sub_field( 'card_title' ); ?>
					<?php $text = get_sub_field( 'card_text' ); ?>
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

	<?php if ( ! empty( $link['url'] ) ) : ?>
		<p>
			<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></a>
		</p>
	<?php endif; ?>
</section>
