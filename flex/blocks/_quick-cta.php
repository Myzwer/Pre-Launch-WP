<?php
	/**
	 * Call to Action block.
	 *
	 * Renders a short call-to-action message with a single button.
	 *
	 * Used in:
	 * - conversion prompts
	 * - signup invitations
	 * - quick engagement sections
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Message field is typically a short paragraph.
	 * - Button links to a primary action such as contact or signup.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$message = get_sub_field( 'message' );
	$link    = get_sub_field( 'link' );
?>
<section class="flex-block flex-block--quick-cta">
	<?php if ( $message ) : ?>
		<p><?php echo nl2br( esc_html( $message ) ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $link['url'] ) ) : ?>
		<p>
			<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></a>
		</p>
	<?php endif; ?>
</section>
