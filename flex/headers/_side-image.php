<?php
	/**
	 * Displays a split header with text/buttons on the left and an image on the right.
	 */

	$primary_button   = get_sub_field( 'primary_button_side' );
	$secondary_button = get_sub_field( 'secondary_button_side' );
	$side_photo       = get_sub_field( 'side_photo' );
	$subtitle         = get_sub_field( 'small_subtitle' );
	$heading          = get_sub_field( 'main_title' );
?>

<div class="grid grid-cols-12">
	<div
		class="col-span-12 text-white bg-black lg:col-span-6 bg-texture min-h-[20rem] lg:min-h-[40rem]"
		style="--bg-texture: url('<?php echo esc_url( get_template_directory_uri() . '/assets/public/img/topography.png' ); ?>');"
	>
		<div class="px-5 text-center content-middle text-pretty">
			<?php if ( $subtitle ) : ?>
				<div class="center add-padding">
					<p class="pb-2 text-xl font-bold lg:text-2xl"><?php echo esc_html( $subtitle ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h1 class="pb-5 text-3xl font-bold uppercase lg:text-5xl"><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>

			<div>
				<?php if ( $primary_button ) :
					$url = esc_url( $primary_button['url'] );
					$label  = esc_html( $primary_button['title'] );
					$target = $primary_button['target'] ? esc_attr( $primary_button['target'] ) : '_self';
					?>
					<a class="mr-5 btn_main" href="<?php echo $url; ?>" target="<?php echo $target; ?>">
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
		</div>
	</div>

	<div class="col-span-12 bg-center bg-no-repeat bg-cover lg:col-span-6 min-h-[16rem] lg:min-h-[40rem]"
		 style="background-image: url('<?php echo esc_url( $side_photo ); ?>');">
	</div>
</div>
