<?php
/*
 * REQUIRED ACF FIELDS:
 * small_subtitle (Text field)
 * main_title (text field)
 * primary_cta (group)
 *  - button_text (text field)
 *  - button_link (link field)
 * side_photo (image)
 *
 * */
?>

<div class="relative bg-scroll bg-no-repeat bg-cover" style="background: linear-gradient(
  rgba(0, 0, 0, 0.45),
  rgba(0, 0, 0, 0.45)
), url('<?php the_sub_field( "side_photo" ); ?>') center center; background-repeat: no-repeat; background-size: cover;
 height: 60vh;">
    <div class="px-5 text-center content-middle-medium text-pretty">
        <div class="center add-padding">
            <h2 class="text-xl font-bold text-white lg:text-2xl lb-2"><?php the_sub_field( "small_subtitle" ); ?></h2>
        </div>
        <h1 class="text-3xl font-bold text-white uppercase lg:text-5xl"><?php the_sub_field( "main_title" ); ?></h1>


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
                        <a href="<?php echo esc_url( $link ); ?>" <?php echo $attrs; ?>
                           class="btn-main">
                            <i class="fa-solid fa-circle-arrow-right"></i> <?php the_sub_field( "button_text" ); ?>
                        </a>
                    </div>

                <?php endif; // Close the if $link block ?>

            <?php endwhile; // Close the while loop ?>
        <?php endif; // Close the if have_rows block ?>

    </div>
</div>



