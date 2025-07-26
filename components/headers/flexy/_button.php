<?php
/*
 * REQUIRED ACF FIELDS:
 * small_subtitle (Text field)
 * main_title (text field)
 * primary_cta (group)
 *  - button_text (text field)
 *  - button_link (link field)
 *
 * */
?>

<div class="bg-black">
    <div class="bg-no-repeat bg-scroll bg-cover relative"
         style="height: 30vh;">
        <div class="content-middle text-center">
            <div class="center add-padding">
                <h2 class="text-white text-xl md:text-2xl lb-2 font-bold"><?php the_sub_field( "small_subtitle" ); ?></h2>
            </div>
            <h1 class="text-white text-3xl md:text-5xl uppercase font-bold"><?php the_sub_field( "main_title" ); ?></h1>

			<?php if ( have_rows( 'primary_cta' ) ): ?>
				<?php while ( have_rows( 'primary_cta' ) ): the_row(); ?>

					<?php
					$link      = get_sub_field( 'button_link' ) ?? get_sub_field( 'button_link_file' );

					// Hide button if link is returning null
					if ( $link ):
						// Get tab status
						$new_tab = get_sub_field( 'new_tab' );
						$attrs = '';
						if ( $new_tab == "yes" ) {
							$attrs = 'target="_blank"';
						} ?>

                        <div class="mt-3">
                            <a href="<?php echo esc_url( $link ); ?>" <?php echo $attrs; ?> class="btn-main">
                                <i class="fa-solid fa-circle-arrow-right"></i> <?php the_sub_field( "button_text" ); ?>
                            </a>
                        </div>

					<?php endif; // Close the if $link block ?>

				<?php endwhile; // Close the while loop ?>
			<?php endif; // Close the if have_rows block ?>

        </div>
    </div>
</div>

