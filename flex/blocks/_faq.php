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
	 * - Answers use a textarea field for simple copy.
	 * - Intended for static display rather than interactive accordions.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$intro = get_sub_field( 'intro' );
?>

<section class="wrap">
	<div class="py-10 grid-12">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div class="prose-theme"><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<?php if ( have_rows( 'faqs' ) ) : ?>
				<div class="grid-12">
					<?php while ( have_rows( 'faqs' ) ) : the_row(); ?>
						<?php $question = get_sub_field( 'faq_question' ); ?>
						<?php $answer = get_sub_field( 'faq_answer' ); ?>

						<article class="col-span-12">
							<?php if ( $question ) : ?>
								<h4 class="heading-4"><?php echo esc_html( $question ); ?></h4>
							<?php endif; ?>

							<?php if ( $answer ) : ?>
								<p><?php echo nl2br( esc_html( $answer ) ); ?></p>
							<?php endif; ?>
						</article>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
