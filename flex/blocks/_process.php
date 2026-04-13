<?php
	/**
	 * Process / steps content block.
	 *
	 * Renders a series of steps describing a process or workflow.
	 *
	 * Used in:
	 * - onboarding instructions
	 * - service signup processes
	 * - step-by-step explanations
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Steps are generated from a repeater field.
	 * - Step content uses a WYSIWYG editor for inline links and buttons.
	 * - Headers should not be used within step text.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$header = get_sub_field( 'header' );
	$intro  = get_sub_field( 'intro' );
	$link   = get_sub_field( 'link' );
?>
<section class="flex-block flex-block--process">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $intro ) : ?>
		<div><?php echo wp_kses_post( $intro ); ?></div>
	<?php endif; ?>

	<?php if ( have_rows( 'steps' ) ) : ?>
		<ol>
			<?php while ( have_rows( 'steps' ) ) : the_row(); ?>
				<li>
					<?php $title = get_sub_field( 'step_title' ); ?>
					<?php $text = get_sub_field( 'step_text' ); ?>
					<?php if ( $title ) : ?>
						<h3><?php echo esc_html( $title ); ?></h3>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<div><?php echo wp_kses_post( $text ); ?></div>
					<?php endif; ?>
				</li>
			<?php endwhile; ?>
		</ol>
	<?php endif; ?>

	<?php if ( ! empty( $link['url'] ) ) : ?>
		<p>
			<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></a>
		</p>
	<?php endif; ?>
</section>
