<?php
	/**
	 * Form block.
	 *
	 * Renders a Gravity Forms form within a section.
	 *
	 * Used in:
	 * - contact forms
	 * - signup forms
	 * - lead generation sections
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Form is rendered using the stored form ID.
	 * - Form output is handled via shortcode injection in PHP.
	 * - Section may include intro content above the form.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$intro   = get_sub_field( 'intro' );
	$form_id = absint( get_sub_field( 'form_id' ) );
?>

<section class="py-10 wrap">
	<div class="grid-12">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div class="prose-theme"><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<?php if ( $form_id ) : ?>
				<div>
					<?php echo do_shortcode( '[gravityform id="' . $form_id . '" title="false" description="false" ajax="true"]' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
