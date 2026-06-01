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
	 * - Section may include header and intro text above the form.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$intro   = get_sub_field( 'intro' );
	$form_id = get_sub_field( 'form_id' );
?>

<section class="wrap">
	<div class="py-8 grid-12 prose-theme">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<?php if ( $form_id ) : ?>
				<div>
					<?php echo do_shortcode( '[gravityform id="' . absint( $form_id ) . '" title="false" description="false" ajax="true"]' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>



