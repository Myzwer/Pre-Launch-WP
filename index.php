<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Pre-Launch WP
 * @since 1.0.0
 */

get_header(); ?>

    <div class="m-4 md:m-10 lg:max-w-4xl lg:text-center lg:mx-auto">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="text-center md:text-left mb-1">
                    <h1>Color Pod</h1>
                    <p>All fields optional</p>
                </div>
                <hr>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 mt-6">
            <div class="col-span-12 lg:col-span-4 card-gradient-1 rounded-xl shadow-xl">
                <div class="text-center p-4">
                    <h2 class = "font-bold text-2xl">Title</h2>
                    <h4 class = "font-semibold">Subtitle</h4>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam commodi consequuntur distinctio doloribus eaque, earum exercitationem, fuga iste labore magni, maxime molestiae nulla pariatur quod sapiente totam vel voluptate?</p>
                    <button class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Call To Action
                    </button>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-4 card-gradient-2 rounded-xl shadow-xl">
                <div class="text-center p-4">
                    <h2 class = "font-bold text-2xl">Title</h2>
                    <h4 class = "font-semibold">Subtitle</h4>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam commodi consequuntur distinctio doloribus eaque, earum exercitationem, fuga iste labore magni, maxime molestiae nulla pariatur quod sapiente totam vel voluptate?</p>
                    <button class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Call To Action
                    </button>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-4 card-gradient-3 rounded-xl shadow-xl">
                <div class="text-center p-4">
                    <h2 class = "font-bold text-2xl">Title</h2>
                    <h4 class = "font-semibold">Subtitle</h4>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam commodi consequuntur distinctio doloribus eaque, earum exercitationem, fuga iste labore magni, maxime molestiae nulla pariatur quod sapiente totam vel voluptate?</p>
                    <button class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Call To Action
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 mt-20">
            <div class="col-span-12">
                <div class="text-center md:text-left mb-1">
                    <h1>PDF Download (four-up)</h1>
                    <p>This configuration always shows four PDF's on one row.</p>
                </div>
                <hr>
            </div>
        </div>


        <div class="grid grid-cols-12 mt-5 gap-6">
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="text-center mb-1">
                    <div class="w-24 text-center m-auto my-3">
                        <img class = "rounded-full" src="https://images.unsplash.com/photo-1508515053963-70c7cc39dfb5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80" alt="">
                    </div>
                    <h2 class = "font-bold text-2xl">PDF Title</h2>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis cumque doloremque error esse exercitationem explicabo iure iusto magni molestiae, nulla odio quam quo repellat vero. Aliquam possimus repellendus voluptate.</p>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="text-center mb-1">
                    <div class="w-24 text-center m-auto my-3">
                        <img class = "rounded-full" src="https://images.unsplash.com/photo-1508515053963-70c7cc39dfb5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80" alt="">
                    </div>
                    <h2 class = "font-bold text-2xl">PDF Title</h2>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis cumque doloremque error esse exercitationem explicabo iure iusto magni molestiae, nulla odio quam quo repellat vero. Aliquam possimus repellendus voluptate.</p>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="text-center mb-1">
                    <div class="w-24 text-center m-auto my-3">
                        <img class = "rounded-full" src="https://images.unsplash.com/photo-1508515053963-70c7cc39dfb5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80" alt="">
                    </div>
                    <h2 class = "font-bold text-2xl">PDF Title</h2>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis cumque doloremque error esse exercitationem explicabo iure iusto magni molestiae, nulla odio quam quo repellat vero. Aliquam possimus repellendus voluptate.</p>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="text-center mb-1">
                    <div class="w-24 text-center m-auto my-3">
                        <img class = "rounded-full" src="https://images.unsplash.com/photo-1508515053963-70c7cc39dfb5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80" alt="">
                    </div>
                    <h2 class = "font-bold text-2xl">PDF Title</h2>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis cumque doloremque error esse exercitationem explicabo iure iusto magni molestiae, nulla odio quam quo repellat vero. Aliquam possimus repellendus voluptate.</p>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();

