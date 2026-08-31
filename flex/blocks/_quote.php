<?php
	/**
	 * Quote / testimonial block.
	 *
	 * Renders a highlighted quote with optional intro, image, and attribution.
	 *
	 * Used in:
	 * - testimonials
	 * - customer or member quotes
	 * - featured statements
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Quote content uses a WYSIWYG field for basic formatting.
	 * - Attribution may include title, company, or location.
	 * - Optional image is displayed as a small avatar-style image.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	$intro       = get_sub_field( 'intro' );
	$quote       = get_sub_field( 'quote' );
	$image       = get_sub_field( 'image' );
	$image_id    = ! empty( $image['ID'] ) ? absint( $image['ID'] ) : 0;
	$name        = get_sub_field( 'name' );
	$attribution = get_sub_field( 'attribution' );
?>

<section class="py-10 wrap">
	<?php if ( $intro ) : ?>
		<div class="pb-8 grid-12">
			<div class="col-span-12 mx-auto text-center">
				<div class="prose-theme">
					<?php echo wp_kses_post( $intro ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="grid-12">
		<div class="col-span-12 md:col-span-10 md:col-start-2">
			<figure class="p-6 rounded-2xl md:p-8">
				<?php if ( $quote ) : ?>
					<div class="prose-theme prose-compact">
						<blockquote class="pl-5 m-0 border-l-4 border-black">
							<?php echo wp_kses_post( $quote ); ?>
						</blockquote>
					</div>
				<?php endif; ?>

				<?php if ( $image_id || $name || $attribution ) : ?>
					<figcaption class="flex gap-4 items-center mt-6">
						<?php if ( $image_id ) : ?>
							<div class="overflow-hidden w-16 h-16 rounded-full shrink-0">
								<?php
									echo wp_get_attachment_image(
										$image_id,
										'thumbnail',
										false,
										array(
											'class'    => 'h-full w-full object-cover',
											'loading'  => 'lazy',
											'decoding' => 'async',
										)
									);
								?>
							</div>
						<?php endif; ?>

						<?php if ( $name || $attribution ) : ?>
							<div>
								<?php if ( $name ) : ?>
									<p class="mb-0 font-bold"><?php echo esc_html( $name ); ?></p>
								<?php endif; ?>

								<?php if ( $attribution ) : ?>
									<p class="mb-0"><?php echo esc_html( $attribution ); ?></p>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</figcaption>
				<?php endif; ?>
			</figure>
		</div>
	</div>
</section>
