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
            <div class="p-3 category"><?php the_category(); ?></div>
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


    <div class="next-prev grid grid-cols-12">
        <div class="col-span-12 text-center">
            <h2 class="">More Episodes</h2>
        </div>

        <div class="col-span-12 md:col-span-6 md:col-start-4 text-center my-10">
            <div class="next-prev grid grid-cols-12">
                <div class="col-span-12 md:col-span-4 mb-10">
					<?php if ( strlen( get_next_post()->post_title ) > 0 ) { ?> <!-- Check if next post exists -->
                        <a href="<?php echo get_permalink( get_adjacent_post( false, '', false ) ); ?>">
                            <!-- Get link of next post-->
                            <a href=""
                               class="bg-black text-white rounded-full font-bold px-8 py-3 transition duration-300 ease-in-out hover:bg-blue-light mt-10">
                                Next Post
                            </a>
                        </a>
					<?php } ?>
                </div>

                <div class="col-span-12 md:col-span-4 mb-10">
                    <a href="/play">
                        <a href=""
                           class="bg-black text-white rounded-full font-bold px-8 py-3 transition duration-300 ease-in-out hover:bg-blue-light mt-10">
                            All Posts
                        </a>
                    </a>
                </div>


                <div class="col-span-12 md:col-span-4 mb-10">
					<?php if ( strlen( get_previous_post()->post_title ) > 0 ) { ?> <!-- Check if previous post exists -->
                        <a href="<?php echo get_permalink( get_adjacent_post( false, '', true ) ); ?>">
                            <!-- Get link of next post -->
                            <a href=""
                               class="bg-black text-white  rounded-full px-8 py-3 transition duration-300 ease-in-out hover:bg-blue-light mt-10">
                                Previous Post
                            </a>
                        </a>
					<?php } ?>
                </div>
            </div>

        </div>
    </div>


<?php
get_footer();
