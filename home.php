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

    <div class="bg-no-repeat bg-scroll bg-cover relative" style="background: linear-gradient(
  rgba(0, 0, 0, 0.45),
  rgba(0, 0, 0, 0.45)
), url('https://images.unsplash.com/photo-1501612780327-45045538702b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2100&q=80') center center;
 height: 60vh;">
        <div class="content-middle text-white text-center">
            <h1 class="text-4xl mb-5">Articles & Podcasts</h1>
            <a href=""
               class="bg-white rounded-full font-bold text-black px-8 py-3 transition duration-300 ease-in-out hover:bg-blue-light mt-10">
                Click here
            </a>
        </div>
    </div>


<!-- Featured Post -->
    <div class="m-4 md:m-10 lg:max-w-4xl lg:text-center lg:mx-auto">
        <div class="grid grid-cols-12 gap-4 mt-6 shadow-xl rounded-xl featured-card">
			<?php $posts_query = new WP_Query( 'posts_per_page=1' ); //limit post to 1 since this is our featured post
			while ( $posts_query->have_posts() ) : $posts_query->the_post();
				?>
                <div class="col-span-12 lg:col-span-7">
					<?php the_post_thumbnail(); ?>
                </div>

                <div class="col-span-12 lg:col-span-5 text-left p-3">
                    <h6 class=""><span class="font-bold">Category</span> - <span
                                class="opacity-60"> <?php echo get_the_date(); ?> </span>
                    </h6>
                    <h2 class="text-3xl font-bold capitalize"><?php echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'; ?></h2>
					<?php the_excerpt( '<p class = "blog-excerpt">', '</p>' ); ?>

                    <a href="<?php echo get_permalink(); ?>">
                        <button class="mx-auto lg:mx-0 shadow-xl bg-black text-white font-bold rounded-full my-6 py-2 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                            Read More
                        </button>
                    </a>
                </div>
			<?php endwhile;
			wp_reset_query(); ?>
        </div>

        <!-- All Other Posts -->
        <div class="grid grid-cols-12 gap-4 mt-6 ">
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
			$paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$per_page       = 2; // How many posts do you want per page?
			$default_offset = 1; // How much offset do you want?

			if ( $paged == 1 ) {
				$offset = $default_offset;
			} else {
				$offset = ( ( $paged - 1 ) * $per_page ) + $default_offset;
			}

			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => $per_page,
				'order'          => 'DESC',
				'offset'         => $offset,
				'paged'          => $paged
			);
			$loop = new WP_Query( $args );

			// Start loop for all posts.
			while ( $loop->have_posts() ) :
				$loop->the_post();
				?>

                <div class="blog-card col-span-12 md:col-span-6 rounded-xl shadow-xl">
					<?php the_post_thumbnail(); ?>
                    <div class="p-4 text-left">
                        <h6 class=""><span class="font-bold">Category</span> - <span
                                    class="opacity-60"> <?php echo get_the_date(); ?> </span>
                        </h6>
                        <h2 class="text-2xl font-bold capitalize"><?php echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'; ?></h2>
						<?php the_excerpt( '<p class = "blog-excerpt">', '</p>' ); ?>
                        <p class="mt-5 font-bold">Written by: <?php the_author(); ?></p>
                        <a href="<?php echo get_permalink(); ?>">
                            <button class="mx-auto lg:mx-0 shadow-xl bg-black text-white font-bold rounded-full my-6 py-2 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
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

