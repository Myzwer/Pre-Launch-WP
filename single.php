<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wordpack-theme
 */

get_header();
?>

    <div class="bg-no-repeat bg-scroll bg-cover relative" style="background-color: #262626;
 height: 60vh;">
        <div class="content-middle text-white text-center">
            <div class = "p-3 category"><?php the_category(); ?></div>
            <h1 class="text-4xl lg:text-6xl mb-5 px-5 uppercase"><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="bg-white text-black">
        <div class="grid grid-cols-12 gap-4 py-10 px-5">
            <div class="col-span-12 md:col-span-10 lg:col-start-2 lg:col-span-7">
		        <?php the_post_thumbnail(); ?>
                <div class="mt-5">
		            <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>



    <div class="m-5 next-prev-nav">
        <div class="grid grid-cols-12 lg:mx-10">
            <div class="col-span-12 md:col-span-9 xl:col-span-7">
                <?php
                the_post_navigation(
                    array(
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'wordpack-theme' ) . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'wordpack-theme' ) . '</span> <span class="nav-title">%title</span>',
                    )
                );
                ?>
            </div>
        </div>
    </div>


<?php
get_footer();
