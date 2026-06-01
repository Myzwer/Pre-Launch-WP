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


	$intro = get_sub_field( 'intro' );
?>

<section class="wrap">
	<div class="py-8 grid-12 prose-theme">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<div class="grid-12">
				<?php if ( have_rows( 'faqs' ) ) : ?>

				<?php while ( have_rows( 'faqs' ) ) : the_row(); ?>
					<div class="col-span-12">
						<?php $question = get_sub_field( 'faq_question' ); ?>
						<?php $answer = get_sub_field( 'faq_answer' ); ?>
						<?php if ( $question ) : ?>
							<h3><?php echo esc_html( $question ); ?></h3>
						<?php endif; ?>
						<?php if ( $answer ) : ?>
							<p><?php echo nl2br( esc_html( $answer ) ); ?></p>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
