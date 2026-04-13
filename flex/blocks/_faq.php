<?php
	/**
	 * FAQ block.
	 *
	 * Renders a list of frequently asked questions and answers.
	 *
	 * Used in:
	 * - FAQ pages
	 * - support or help sections
	 * - informational content pages
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Questions are stored in a repeater field.
	 * - Answers use a WYSIWYG editor for light formatting.
	 * - Intended for static display rather than interactive accordions.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$header = get_sub_field( 'header' );
	$intro  = get_sub_field( 'intro' );
?>
<section class="flex-block flex-block--faq">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $intro ) : ?>
		<div><?php echo wp_kses_post( $intro ); ?></div>
	<?php endif; ?>

	<?php if ( have_rows( 'faqs' ) ) : ?>
		<div>
			<?php while ( have_rows( 'faqs' ) ) : the_row(); ?>
				<article>
					<?php $question = get_sub_field( 'faq_question' ); ?>
					<?php $answer = get_sub_field( 'faq_answer' ); ?>
					<?php if ( $question ) : ?>
						<h3><?php echo esc_html( $question ); ?></h3>
					<?php endif; ?>
					<?php if ( $answer ) : ?>
						<p><?php echo nl2br( esc_html( $answer ) ); ?></p>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</section>
