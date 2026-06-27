<?php
	/**
	 * Process / steps content block.
	 *
	 * Renders a series of steps describing a process or workflow.
	 *
	 * Used in:
	 * - onboarding instructions
	 * - service signup processes
	 * - step-by-step explanations
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Steps are generated from a repeater field.
	 * - Step content uses a WYSIWYG editor for inline links and buttons.
	 * - Headers should not be used within step text.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$intro = get_sub_field( 'intro' );
	$link  = get_sub_field( 'link' );
?>

<section class="py-10 wrap">
	<div class="grid-12">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div class="prose-theme"><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<div class="grid-12">
				<?php if ( have_rows( 'steps' ) ) : ?>
					<div class="col-span-12 pb-5">
						<?php while ( have_rows( 'steps' ) ) : the_row(); ?>
							<?php $title = get_sub_field( 'step_title' ); ?>
							<?php $text = get_sub_field( 'step_text' ); ?>

							<article>
								<?php if ( $title ) : ?>
									<h4 class="heading-4"><?php echo esc_html( $title ); ?></h4>
								<?php endif; ?>

								<?php if ( $text ) : ?>
									<div class="pb-5 prose-theme"><?php echo wp_kses_post( $text ); ?></div>
								<?php endif; ?>
							</article>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="grid-12">
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
		</div>
	</div>
</section>
