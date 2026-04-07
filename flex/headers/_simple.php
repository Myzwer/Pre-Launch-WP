<?php
	/**
	 * Displays a simple header with centered text and optional buttons.
	 */

	$primary_button   = get_sub_field( 'primary_button' );
	$secondary_button = get_sub_field( 'secondary_button' );
?>

<div class="bg-black">
	<div
		class="relative bg-no-repeat bg-cover bg-texture"
		style="height: 30vh; --bg-texture: url('<?php echo esc_url( get_template_directory_uri() . '/assets/public/img/topography.png' ); ?>');"
	>
		<div class="px-5 text-center content-middle text-pretty">
			<div class="center add-padding">
				<h2 class="pb-2 text-xl font-bold text-white md:text-2xl"><?php the_sub_field( 'small_subtitle' ); ?></h2>
			</div>

			<h1 class="text-3xl font-bold text-white uppercase md:text-5xl"><?php the_sub_field( 'main_title' ); ?></h1>

			<?php if ( $primary_button || $secondary_button ) : ?>
				<div class="inline-flex flex-wrap gap-4 justify-center pt-5">
					<?php if ( $primary_button ) :
						$url = esc_url( $primary_button['url'] );
						$title = esc_html( $primary_button['title'] );
						$target = $primary_button['target'] ? esc_attr( $primary_button['target'] ) : '_self';
						?>
						<a class="btn_main" href="<?php echo $url; ?>" target="<?php echo $target; ?>">
							<?php echo $title; ?>
						</a>
					<?php endif; ?>

					<?php if ( $secondary_button ) :
						$url = esc_url( $secondary_button['url'] );
						$title = esc_html( $secondary_button['title'] );
						$target = $secondary_button['target'] ? esc_attr( $secondary_button['target'] ) : '_self';
						?>
						<a class="btn_ghost_white" href="<?php echo $url; ?>" target="<?php echo $target; ?>">
							<?php echo $title; ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
