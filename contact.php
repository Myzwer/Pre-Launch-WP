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
<div class="bg-no-repeat bg-scroll bg-cover relative" style="background: linear-gradient(
  rgba(0, 0, 0, 0.45),
  rgba(0, 0, 0, 0.45)
), url('https://images.unsplash.com/photo-1501612780327-45045538702b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2100&q=80') center center;
 height: 40vh;">
    <div class="content-middle text-white text-center">
        <h1 class="text-4xl md:text-5xl mb-3">Contact</h1>
    </div>
</div>

<div class="bg-white mb-10">
    <div class="mx-4 md:mx-10 lg:max-w-4xl lg:text-center lg:mx-auto pt-10">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 card-gradient-1 rounded-xl shadow-2xl mb-10">
                <div class="text-center p-5 md:p-10 text-black">
                    <h2 class="text-3xl text-left">Want to Contact Us?</h2>
                    <p class="text-left mb-10">I'm baby irony ramps shoreditch microdosing, raclette tattooed gentrify prism art party gastropub woke quinoa. Vape bitters kale chips everyday carry asymmetrical. Austin hot chicken 90's tousled woke tattooed pabst prism art party meditation hell of slow-carb. Seitan tofu mlkshk asymmetrical 8-bit letterpress chambray brooklyn taiyaki flexitarian tumeric truffaut. Everyday carry hell of sriracha, listicle brooklyn unicorn helvetica quinoa. Helvetica hexagon DIY before they sold out cray, cloud bread church-key.</p>
                    <a href=""
                       class="bg-orange rounded-full font-bold shadow-xl text-black px-8 py-3 transition duration-300 ease-in-out hover:bg-orange-hover">
                        Make Magic
                    </a>
                </div>
            </div>

            <div class="col-span-12 md:col-span-8 card-gradient-1 rounded-xl shadow-2xl">
                <div class="text-left p-10 text-black form">

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
                        <div class="card-gradient-1 rounded-xl shadow-2xl">
                            <div class="text-left p-10 text-black">
                                <h2 class="text-3xl text-left">Get In Touch</h2>
                                <p class="text-left"><i class="fas fa-phone text-xl"></i> 123-456-7890</p>
                                <p class="text-left"><i class="far fa-envelope text-xl"></i> email@domain.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="card-gradient-1 rounded-xl shadow-2xl">
                            <div class="text-left p-10 text-black">
                                <h2 class="text-3xl text-left">Second Block</h2>
                                <p class="text-left font-bold leading-5">Want like a job or something?</p>
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