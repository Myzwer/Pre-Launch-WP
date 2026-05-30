<?php
	/**
	 * Accordion content block.
	 *
	 * Renders collapsible content sections controlled by titles.
	 *
	 * Used in:
	 * - expandable FAQs
	 * - detailed content sections
	 * - progressive information disclosure
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Items are generated from a repeater field.
	 * - Content uses a WYSIWYG editor.
	 * - Headers should not be used inside accordion body content.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	$header = get_sub_field( 'header' );
	$intro  = get_sub_field( 'intro' );
?>

<section class="py-8 wrap accordion-block">
	<div class="grid-12">
		<?php if ( $header || $intro ) : ?>
			<div class="col-span-12 lg:col-span-10 lg:col-start-2">
				<?php if ( $header ) : ?>
					<h2 class="accordion-block__heading">
						<?php echo esc_html( $header ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $intro ) : ?>
					<div class="accordion-block__intro prose-theme">
						<?php echo wp_kses_post( $intro ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( have_rows( 'accordion_items' ) ) : ?>
			<div class="col-span-12 lg:col-span-10 lg:col-start-2">
				<div class="accordion" data-accordion>
					<?php while ( have_rows( 'accordion_items' ) ) : the_row(); ?>
						<?php
						$title   = get_sub_field( 'accordion_title' );
						$content = get_sub_field( 'accordion_content' );
						?>

						<?php if ( $title && $content ) : ?>
							<details class="accordion__item">
								<summary class="accordion__summary">
									<span class="accordion__title">
										<?php echo esc_html( $title ); ?>
									</span>
								</summary>

								<div class="accordion__panel prose-theme">
									<?php echo wp_kses_post( $content ); ?>
								</div>
							</details>
						<?php endif; ?>
					<?php endwhile; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
