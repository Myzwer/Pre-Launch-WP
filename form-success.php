<?php
/**
 * Template Name: Template - Form Success
 *
 * This page is used anytime gravity forms has a successful submission so users can know it worked.
 *
 * Usage: Use in WP-Admin, select "Form Success" from page template.
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */

get_header(); ?>

    <div class="bg-blue-gradient">
        <div class="bg-no-repeat bg-scroll bg-cover relative"
             style="background:
                     url('<?php echo get_template_directory_uri(); ?>/assets/src/img/topography-salty.png') center center;">
            <div class="grid grid-cols-12 text-black">
                <div class="col-span-12 md:col-span-6 text-center relative">
                    <div class="content-middle-medium prose py-20">
                        <?php the_field('content'); ?>

                        <?php
                        // Check value exists.
                        if (have_rows('call_to_action')) :

                            // used for alternating colors
                            $counter = 0;

                            // Loop through rows.
                            while (have_rows('call_to_action')) : the_row();
                                switch (get_row_layout()) {
                                    case 'file_download_cta':
                                        ?>
                                        <div class="block">
                                            <a class="no-underline" href="<?php the_sub_field("file_for_download"); ?>"
                                               download>
                                                <button class="fab-main mt-3">
                                                    <i class="fa-regular fa-arrow-down-to-line"></i> <?php the_sub_field("button_text"); ?>
                                                </button>
                                            </a>
                                        </div>
                                        <?php
                                        break;

                                    case 'primary_cta':
                                        ?>
                                        <div class="block">
                                            <a href="<?php the_sub_field("button_link"); ?>">
                                                <button class="fab-main mt-3">
                                                    <i class="fa-solid fa-circle-arrow-right"></i> <?php the_sub_field("button_text"); ?>
                                                </button>
                                            </a>
                                        </div>
                                        <?php
                                        break;

                                    case 'secondary_cta':
                                        ?>
                                        <div class="block">
                                            <a href="<?php the_sub_field("button_link"); ?>">
                                                <button class="ghost-black mt-3">
                                                    <?php the_sub_field("button_text"); ?>
                                                </button>
                                            </a>
                                        </div>
                                        <?php
                                        break;


                                    // FIXME: Only for building/debugging, shouldn't be left in for production
                                    default:
                                        echo "Unhandled content block: " . get_row_layout();
                                        break;
                                }

                            endwhile;
                        else :
                        endif;
                        ?>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <div class="bg-no-repeat bg-scroll bg-cover relative"
                         style="background: url('<?php the_field('side_image'); ?>') center center;
                                 height: 80vh;">
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php get_footer();
