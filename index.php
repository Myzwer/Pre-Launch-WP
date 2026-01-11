<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * Because of the way this template was built, this page will rarely ever be seen.
 * Frontpage will be what users see first, not this.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @since 1.0.0
 */

get_header(); ?>

    <div class="m-4 md:m-10 lg:mx-auto lg:max-w-4xl lg:text-center">
        <div class="grid">
        <div class="grid-cols-12">
            <div class="col-span-12">
                <div class="mb-1 text-center md:text-left">
                    <h1>Color Pod</h1>
                    <p>All fields optional</p>
                </div>
                <hr>
            </div>
        </div>
        </div>

        <div class="grid grid-cols-12 gap-4 mt-6">
            <div class="col-span-12 rounded-xl shadow-xl lg:col-span-4 card-gradient-1">
                <div class="p-4 text-center">
                    <h2 class = "text-2xl font-bold">Title</h2>
                    <h4 class = "font-semibold">Subtitle</h4>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam commodi consequuntur distinctio doloribus eaque, earum exercitationem, fuga iste labore magni, maxime molestiae nulla pariatur quod sapiente totam vel voluptate?</p>
                    <button class="py-4 px-8 my-6 mx-auto font-bold text-gray-800 bg-white rounded-full shadow-lg transition duration-300 ease-in-out transform lg:mx-0 hover:underline hover:scale-105 focus:outline-none focus:shadow-outline">
                        Call To Action
                    </button>
                </div>
            </div>

            <div class="col-span-12 rounded-xl shadow-xl md:col-span-6 lg:col-span-4 card-gradient-2">
                <div class="p-4 text-center">
                    <h2 class = "text-2xl font-bold">Title</h2>
                    <h4 class = "font-semibold">Subtitle</h4>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam commodi consequuntur distinctio doloribus eaque, earum exercitationem, fuga iste labore magni, maxime molestiae nulla pariatur quod sapiente totam vel voluptate?</p>
                    <button class="py-4 px-8 my-6 mx-auto font-bold text-gray-800 bg-white rounded-full shadow-lg transition duration-300 ease-in-out transform lg:mx-0 hover:underline hover:scale-105 focus:outline-none focus:shadow-outline">
                        Call To Action
                    </button>
                </div>
            </div>

            <div class="col-span-12 rounded-xl shadow-xl md:col-span-6 lg:col-span-4 card-gradient-3">
                <div class="p-4 text-center">
                    <h2 class = "text-2xl font-bold">Title</h2>
                    <h4 class = "font-semibold">Subtitle</h4>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam commodi consequuntur distinctio doloribus eaque, earum exercitationem, fuga iste labore magni, maxime molestiae nulla pariatur quod sapiente totam vel voluptate?</p>
                    <button class="py-4 px-8 my-6 mx-auto font-bold text-gray-800 bg-white rounded-full shadow-lg transition duration-300 ease-in-out transform lg:mx-0 hover:underline hover:scale-105 focus:outline-none focus:shadow-outline">
                        Call To Action
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 mt-20">
            <div class="col-span-12">
                <div class="mb-1 text-center md:text-left">
                    <h1>PDF Download (four-up)</h1>
                    <p>This configuration always shows four PDF's on one row.</p>
                </div>
                <hr>
            </div>
        </div>


        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="mb-1 text-center">
                    <div class="m-auto my-3 w-24 text-center">
                        <img class = "rounded-full" src="https://images.unsplash.com/photo-1508515053963-70c7cc39dfb5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80" alt="">
                    </div>
                    <h2 class = "text-2xl font-bold">PDF Title</h2>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis cumque doloremque error esse exercitationem explicabo iure iusto magni molestiae, nulla odio quam quo repellat vero. Aliquam possimus repellendus voluptate.</p>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="mb-1 text-center">
                    <div class="m-auto my-3 w-24 text-center">
                        <img class = "rounded-full" src="https://images.unsplash.com/photo-1508515053963-70c7cc39dfb5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80" alt="">
                    </div>
                    <h2 class = "text-2xl font-bold">PDF Title</h2>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis cumque doloremque error esse exercitationem explicabo iure iusto magni molestiae, nulla odio quam quo repellat vero. Aliquam possimus repellendus voluptate.</p>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="mb-1 text-center">
                    <div class="m-auto my-3 w-24 text-center">
                        <img class = "rounded-full" src="https://images.unsplash.com/photo-1508515053963-70c7cc39dfb5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80" alt="">
                    </div>
                    <h2 class = "text-2xl font-bold">PDF Title</h2>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis cumque doloremque error esse exercitationem explicabo iure iusto magni molestiae, nulla odio quam quo repellat vero. Aliquam possimus repellendus voluptate.</p>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="mb-1 text-center">
                    <div class="m-auto my-3 w-24 text-center">
                        <img class = "rounded-full" src="https://images.unsplash.com/photo-1508515053963-70c7cc39dfb5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80" alt="">
                    </div>
                    <h2 class = "text-2xl font-bold">PDF Title</h2>
                    <p class = "text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis cumque doloremque error esse exercitationem explicabo iure iusto magni molestiae, nulla odio quam quo repellat vero. Aliquam possimus repellendus voluptate.</p>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
