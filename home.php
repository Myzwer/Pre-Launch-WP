<?php
/**
 * Template Name: Posts Page
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @since 1.0.0
 */

get_header(); ?>

    <div class="relative bg-scroll bg-no-repeat bg-cover" style="background: linear-gradient(
  rgba(0, 0, 0, 0.45),
  rgba(0, 0, 0, 0.45)
), url('https://images.unsplash.com/photo-1501612780327-45045538702b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2100&q=80') center center; background-repeat: no-repeat; background-size: cover;
 height: 60vh;">
        <div class="text-center text-white content-middle">
            <h1 class="mb-5 text-4xl">Articles & Podcasts</h1>
            <a href=""
               class="py-3 px-8 mt-10 font-bold text-black bg-white rounded-full transition duration-300 ease-in-out hover:bg-blue-light">
                Click here
            </a>
        </div>
    </div>


<!-- Featured Post -->
    <div class="m-4 md:m-10 lg:mx-auto lg:max-w-4xl lg:text-center">
        <div class="grid grid-cols-12 gap-4 mt-6 rounded-xl shadow-xl featured-card">
            <div class="col-span-12 mx-auto text-center">
                <h3 class="mb-3 text-2xl font-bold md:text-3xl">Latest Post<?php // this is the formatting for ACF: the_field('body_title_2', $post_id);?></h3>
            </div>
			<?php $posts_query = new WP_Query('posts_per_page=1'); //limit post to 1 since this is our featured post
while ($posts_query->have_posts()) : $posts_query->the_post();
    ?>
                <div class="col-span-12 lg:col-span-7">
					<?php the_post_thumbnail(); ?>
                </div>

                <div class="col-span-12 p-3 text-left lg:col-span-5">
                    <h6 class=""><span class="font-bold">Category</span> - <span
                                class="opacity-60"> <?php echo get_the_date(); ?> </span>
                    </h6>
                    <h2 class="text-3xl font-bold capitalize"><?php echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'; ?></h2>
					<?php the_excerpt('<p class = "blog-excerpt">', '</p>'); ?>

                    <a href="<?php echo get_permalink(); ?>">
                        <button class="py-2 px-8 my-6 mx-auto font-bold text-white bg-black rounded-full shadow-lg shadow-xl transition duration-300 ease-in-out transform lg:mx-0 hover:scale-105 focus:outline-none focus:shadow-outline">
                            Read More
                        </button>
                    </a>
                </div>
			<?php endwhile;
wp_reset_query(); ?>
        </div>

        <!-- All Other Posts -->
        <div class="grid grid-cols-12 gap-4 mt-6">
            <div class="col-span-12 mx-auto mt-10 text-center">
                <h3 class="mb-3 text-2xl font-bold md:text-3xl">All Posts<?php // this is the formatting for ACF: the_field('body_title_2', $post_id);?></h3>
            </div>
			<?php
/*
 * This little php block handles a few things.
 * Overrides Wordpress' posts per page in admin.
 * Setting this here allows for you to have it different somewhere else.
 * Skip the first post since it is shown above in the featured post
 * The if/else statement fixes pagination so it doesn't skip those too.
 * Credit for the fix: https://wordpress.stackexchange.com/questions/261405/wp-query-with-offset-breaks-wp-pagenavi-or-any-pagination/335115#335115?newreg=0217492f5a8a47e28bf0c8a72200ebb9
 *
 */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$per_page = 2; // How many posts do you want per page?
$default_offset = 1; // How much offset do you want?

if ($paged == 1) {
    $offset = $default_offset;
} else {
    $offset = (($paged - 1) * $per_page) + $default_offset;
}

$args = [
    'post_type' => 'post',
    'posts_per_page' => $per_page,
    'order' => 'DESC',
    'offset' => $offset,
    'paged' => $paged,
];
$loop = new WP_Query($args);

// Start loop for all posts.
while ($loop->have_posts()) :
    $loop->the_post();
    ?>

                <div class="col-span-12 rounded-xl shadow-xl md:col-span-6 blog-card">
					<?php the_post_thumbnail(); ?>
                    <div class="p-4 text-left">
                        <h6 class=""><span class="font-bold">Category</span> - <span
                                    class="opacity-60"> <?php echo get_the_date(); ?> </span>
                        </h6>
                        <h2 class="text-2xl font-bold capitalize"><?php echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'; ?></h2>
						<?php the_excerpt('<p class = "blog-excerpt">', '</p>'); ?>
                        <p class="mt-5 font-bold">Written by: <?php the_author(); ?></p>
                        <a href="<?php echo get_permalink(); ?>">
                            <button class="py-2 px-8 my-6 mx-auto font-bold text-white bg-black rounded-full shadow-lg shadow-xl transition duration-300 ease-in-out transform lg:mx-0 hover:scale-105 focus:outline-none focus:shadow-outline">
                                Read More
                            </button>
                        </a>
                    </div>
                </div>

			<?php endwhile; ?>
        </div>
		<?php wpbeginner_numeric_posts_nav(); ?>

    </div>


<?php
get_footer();
