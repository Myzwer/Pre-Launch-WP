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

<section class="py-10 wrap">
	<div class="grid-12">
		<div class="col-span-12 text-center">
			<?php if ( $message ) : ?>
				<h3 class="heading-3"><?php echo nl2br( esc_html( $message ) ); ?></h3>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $link['url'] ) ) : ?>
			<div class="col-span-12 mx-auto text-center">
				<a
					class="btn_main"
					href="<?php echo esc_url( $link['url'] ); ?>"
					<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
				>
					<span><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></span>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
