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


	$header  = get_sub_field( 'header' );
	$intro   = get_sub_field( 'intro' );
	$form_id = get_sub_field( 'form_id' );
?>
<section class="flex-block flex-block--form">
	<?php if ( $header ) : ?>
		<h2><?php echo esc_html( $header ); ?></h2>
	<?php endif; ?>

	<?php if ( $intro ) : ?>
		<div><?php echo wp_kses_post( $intro ); ?></div>
	<?php endif; ?>

	<?php if ( $form_id ) : ?>
		<div>
			<?php echo do_shortcode( '[gravityform id="' . absint( $form_id ) . '" title="false" description="false" ajax="true"]' ); ?>
		</div>
	<?php endif; ?>
</section>
