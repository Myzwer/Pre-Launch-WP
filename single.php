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
<?php
// Get Author ID for profile photo
$get_author_id = get_the_author_meta('ID');
?>
    <div class="bg-no-repeat bg-scroll bg-cover relative" style="background: linear-gradient(
  rgba(0, 0, 0, 0.45),
  rgba(0, 0, 0, 0.45)
), url('https://images.unsplash.com/photo-1501612780327-45045538702b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2100&q=80') center center; background-repeat: no-repeat; background-size: cover;
 height: 30vh;">
    </div>

    <div class="bg-white text-black relative">
        <div class="grid grid-cols-12 gap-4 pb-10 px-5">
            <div class="col-span-12">
                <div class="text-center mx-auto">
                    <img class = "text-center mx-auto rounded-full shadow-xl -mt-28 z-5" src="<?php echo get_avatar_url($get_author_id, ['size' => '200']);?>" alt="">
                    <h2 class = "mt-3 text-2xl font-bold"><?php echo the_author(); ?></h2>
                </div>
            </div>

            <div class="col-span-12 md:col-span-10 lg:col-start-3 lg:col-span-8">
                <div class="mt-5">
                    <h1 class = "text-5xl uppercase"><?php echo get_the_title(); ?></h1>
                    <h3 class = "font-bold mt-2 mb-5 text-xl"><?php echo get_the_date(); ?></h3>
                    <div class="blog-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="next-prev grid grid-cols-12">
        <div class="col-span-12 text-center mx-auto my-5">
            <h3 class="text-2xl md:text-3xl font-bold">Read More</h3>
        </div>

        <div class="col-span-12 md:col-span-6 md:col-start-4 text-center my-5">
            <div class="next-prev grid grid-cols-12">
                <div class="col-span-12 md:col-span-4 mb-10">
                    <?php $next = get_permalink(get_adjacent_post(false,'',false));
                    if ($next != get_permalink()) { ?>
                        <a href="<?php echo $next; ?>"
                           class="uppercase inline-block rounded-md mt-3 py-3 px-6 text-white bg-gray-dark hover:bg-gray-darkest transition duration-300">
                            Next Post
                        </a>
                    <?php } ?>
                </div>

                <div class="col-span-12 md:col-span-4 mb-10">
                    <a href="/blog"
                       class="uppercase inline-block rounded-md mt-3 py-3 px-6 text-white bg-gray-dark hover:bg-gray-darkest transition duration-300">
                        All Posts
                    </a>
                </div>


                <div class="col-span-12 md:col-span-4 mb-10">
                    <?php $prev = get_permalink(get_adjacent_post(false,'',true));
                    if ($prev != get_permalink()) { ?>
                        <a href="<?php echo $prev; ?>"
                           class="uppercase inline-block rounded-md mt-3 py-3 px-6 text-white bg-gray-dark hover:bg-gray-darkest transition duration-300">
                            Previous Post
                        </a>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>

<?php
get_footer();
