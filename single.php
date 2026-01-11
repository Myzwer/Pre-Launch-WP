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
    <div class="relative bg-scroll bg-no-repeat bg-cover" style="background: linear-gradient(
  rgba(0, 0, 0, 0.45),
  rgba(0, 0, 0, 0.45)
), url('https://images.unsplash.com/photo-1501612780327-45045538702b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2100&q=80') center center; background-repeat: no-repeat; background-size: cover;
 height: 30vh;">
    </div>

    <div class="relative text-black bg-white">
        <div class="grid grid-cols-12 gap-4 px-5 pb-10">
            <div class="col-span-12">
                <div class="mx-auto text-center">
                    <img class = "mx-auto -mt-28 text-center rounded-full shadow-xl z-5" src="<?php echo get_avatar_url($get_author_id, ['size' => '200']);?>" alt="">
                    <h2 class = "mt-3 text-2xl font-bold"><?php echo the_author(); ?></h2>
                </div>
            </div>

            <div class="col-span-12 md:col-span-10 lg:col-span-8 lg:col-start-3">
                <div class="mt-5">
                    <h1 class = "text-5xl uppercase"><?php echo get_the_title(); ?></h1>
                    <h3 class = "mt-2 mb-5 text-xl font-bold"><?php echo get_the_date(); ?></h3>
                    <div class="blog-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-12 next-prev">
        <div class="col-span-12 my-5 mx-auto text-center">
            <h3 class="text-2xl font-bold md:text-3xl">Read More</h3>
        </div>

        <div class="col-span-12 my-5 text-center md:col-span-6 md:col-start-4">
            <div class="grid grid-cols-12 next-prev">
                <div class="col-span-12 mb-10 md:col-span-4">
                    <?php $next = get_permalink(get_adjacent_post(false, '', false));
if ($next != get_permalink()) { ?>
                        <a href="<?php echo $next; ?>"
                           class="inline-block py-3 px-6 mt-3 text-white uppercase rounded-md transition duration-300 bg-gray-dark hover:bg-gray-darkest">
                            Next Post
                        </a>
                    <?php } ?>
                </div>

                <div class="col-span-12 mb-10 md:col-span-4">
                    <a href="/blog"
                       class="inline-block py-3 px-6 mt-3 text-white uppercase rounded-md transition duration-300 bg-gray-dark hover:bg-gray-darkest">
                        All Posts
                    </a>
                </div>


                <div class="col-span-12 mb-10 md:col-span-4">
                    <?php $prev = get_permalink(get_adjacent_post(false, '', true));
if ($prev != get_permalink()) { ?>
                        <a href="<?php echo $prev; ?>"
                           class="inline-block py-3 px-6 mt-3 text-white uppercase rounded-md transition duration-300 bg-gray-dark hover:bg-gray-darkest">
                            Previous Post
                        </a>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>

<?php
get_footer();
