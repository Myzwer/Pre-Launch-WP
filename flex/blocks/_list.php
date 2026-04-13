<?php
	/**
	 * List content block.
	 *
	 * Renders a repeating list of titled items with optional descriptive text.
	 *
	 * Used in:
	 * - service lists
	 * - feature highlights
	 * - informational bullet sections
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Items are generated from a repeater field.
	 * - Item descriptions use WYSIWYG editors for light formatting.
	 * - Optional button may appear after the list.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$header = get_sub_field( 'header' );
	$intro  = get_sub_field( 'intro' );
	$link   = get_sub_field( 'link' );
?>
<section class="flex-block flex-block--list">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $intro ) : ?>
		<div><?php echo wp_kses_post( $intro ); ?></div>
	<?php endif; ?>

	<?php if ( have_rows( 'list_items' ) ) : ?>
		<div>
			<?php while ( have_rows( 'list_items' ) ) : the_row(); ?>
				<article>
					<?php $title = get_sub_field( 'list_item_title' ); ?>
					<?php $subtext = get_sub_field( 'list_item_subtext' ); ?>
					<?php if ( $title ) : ?>
						<h3><?php echo esc_html( $title ); ?></h3>
					<?php endif; ?>
					<?php if ( $subtext ) : ?>
						<div><?php echo wp_kses_post( $subtext ); ?></div>
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
