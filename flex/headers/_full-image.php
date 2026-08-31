<?php
	/**
	 * Displays a centered header with optional buttons over a darkened background image.
	 */

	$primary_button   = get_sub_field( 'primary_button' );
	$secondary_button = get_sub_field( 'secondary_button' );
	$background_photo = get_sub_field( 'background_photo' );
	$subtitle         = get_sub_field( 'small_subtitle' );
	$heading          = get_sub_field( 'main_title' );
?>

<div class="bg-black">
	<div
		class="relative bg-media bg-overlay-<?php the_sub_field( 'background_tint_level' ); ?> bg-cover bg-center bg-no-repeat"
		style="min-height: 30vh; --bg-image: url('<?php echo esc_url( $background_photo ); ?>');"
	>
		<div class="px-5 text-center content-middle text-pretty">
			<?php if ( $subtitle ) : ?>
				<div class="center add-padding">
					<p class="pb-2 text-xl font-bold text-white md:text-2xl">
						<?php echo esc_html( $subtitle ); ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h1 class="text-3xl font-bold text-white uppercase md:text-5xl"><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>

			<?php if ( $primary_button || $secondary_button ) : ?>
				<div class="inline-flex flex-wrap gap-4 justify-center pt-5">
					<?php if ( $primary_button ) :
						$url = esc_url( $primary_button['url'] );
						$label  = esc_html( $primary_button['title'] );
						$target = $primary_button['target'] ? esc_attr( $primary_button['target'] ) : '_self';
						?>
						<a class="btn_main" href="<?php echo $url; ?>" target="<?php echo $target; ?>">
							<?php echo $label; ?>
						</a>
					<?php endif; ?>

					<?php if ( $secondary_button ) :
						$url = esc_url( $secondary_button['url'] );
						$label  = esc_html( $secondary_button['title'] );
						$target = $secondary_button['target'] ? esc_attr( $secondary_button['target'] ) : '_self';
						?>
						<a class="btn_ghost_white" href="<?php echo $url; ?>" target="<?php echo $target; ?>">
							<?php echo $label; ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
