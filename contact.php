<?php
/**
 * Template Name: Contact
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @since 1.0.0
 */

get_header(); ?>
    <div class="relative bg-scroll bg-cover" style="background: linear-gradient(
            rgba(0, 0, 0, 0.45),
            rgba(0, 0, 0, 0.45)
            ), url('<?php the_field('background_image'); ?>') center center / cover no-repeat;
            height: 40vh;">
        <div class="text-white content-middle prose force-white">
            <?php the_field('page_title'); ?>
        </div>
    </div>

<div class="mb-10 bg-white">
    <div class="pt-10 mx-4 md:mx-10 lg:mx-auto lg:max-w-4xl lg:text-center">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-10 rounded-xl shadow-2xl card-gradient-1">
                <div class="p-5 text-center text-black md:p-10">
                    <h2 class="text-3xl text-left">Want to Contact Us?</h2>
                    <p class="mb-10 text-left">I'm baby irony ramps shoreditch microdosing, raclette tattooed gentrify prism art party gastropub woke quinoa. Vape bitters kale chips everyday carry asymmetrical. Austin hot chicken 90's tousled woke tattooed pabst prism art party meditation hell of slow-carb. Seitan tofu mlkshk asymmetrical 8-bit letterpress chambray brooklyn taiyaki flexitarian tumeric truffaut. Everyday carry hell of sriracha, listicle brooklyn unicorn helvetica quinoa. Helvetica hexagon DIY before they sold out cray, cloud bread church-key.</p>
                    <a href=""
                       class="py-3 px-8 font-bold text-black rounded-full shadow-xl transition duration-300 ease-in-out bg-orange hover:bg-orange-hover">
                        Make Magic
                    </a>
                </div>
            </div>

            <div class="col-span-12 rounded-xl shadow-2xl md:col-span-8 card-gradient-1">
                <div class="p-10 text-left text-black form">

                    <!-- This will generate your form when you add it in WP Admin. -->
                    <?php if (have_posts()) : while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    else: ?>
                        <p>Sorry, no posts matched your criteria.</p>
                    <?php endif; ?>

                </div>
            </div>

            <div class="col-span-12 md:col-span-4">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <div class="rounded-xl shadow-2xl card-gradient-1">
                            <div class="p-10 text-left text-black">
                                <h2 class="text-3xl text-left">Get In Touch</h2>
                                <p class="text-left"><i class="text-xl fas fa-phone"></i> 123-456-7890</p>
                                <p class="text-left"><i class="text-xl far fa-envelope"></i> email@domain.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="rounded-xl shadow-2xl card-gradient-1">
                            <div class="p-10 text-left text-black">
                                <h2 class="text-3xl text-left">Second Block</h2>
                                <p class="font-bold leading-5 text-left">Want like a job or something?</p>
                                <p class="text-left"><i class="far fa-envelope"></i> email@domain.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer();
