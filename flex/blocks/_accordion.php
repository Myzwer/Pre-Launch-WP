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
	 * - Intro content uses a WYSIWYG editor.
	 * - Items are generated from a repeater field.
	 * - Accordion body content uses a WYSIWYG editor.
	 * - Headers should not be used inside accordion body content.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	$intro = get_sub_field( 'intro' );
?>

<section class="wrap accordion-block">
	<div class="py-8 grid-12 prose-theme">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div class="accordion-block__intro">
					<?php echo wp_kses_post( $intro ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( have_rows( 'accordion_items' ) ) : ?>
			<div class="col-span-12">
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

								<div class="accordion__panel">
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
