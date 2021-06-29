<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.sass).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wordpack Template
 * @since 1.0.0
 */

get_header(); ?>

    <div class="gradient text-white">
        <div class="pt-24">
            <div class="container px-3 flex flex-wrap flex-col md:flex-row items-center">
                <!--Left Col-->
                <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
                    <p class="uppercase tracking-loose w-full">What business are you?</p>
                    <h1 class="my-4 text-5xl font-bold leading-tight">
                        Main Hero Message to sell yourself!
                    </h1>
                    <p class="leading-normal text-2xl mb-8">
                        Sub-hero message, not too long and not too short. Make it just right!
                    </p>
                    <button class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Subscribe
                    </button>
                </div>
                <!--Right Col-->
                <div class="w-full md:w-3/5 py-6 text-center">
                    <img class="w-full md:w-4/5 z-50" src=""/>
                </div>
            </div>
        </div>

        <div class="relative -mt-12 lg:-mt-24">
            <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
                        <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496"
                              opacity="0.100000001"></path>
                        <path
                                d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                                opacity="0.100000001"
                        ></path>
                        <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z"
                              id="Path-4" opacity="0.200000003"></path>
                    </g>
                    <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
                        <path
                                d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"
                        ></path>
                    </g>
                </g>
            </svg>
        </div>
    </div>




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





<!--    <div class="grid grid-cols-12">
        <div class="col-span-12 sm:col-span-6 lg:col-span-4">1</div>
        <div class="col-span-12 sm:col-span-6 lg:col-span-4">1</div>
        <div class="col-span-12 sm:col-span-6 lg:col-span-4">1</div>
    </div>-->

    <!--
    TODO:
    Import _S functionality
    Set up some base styles
    Set up tree-shaking
    Navwalker
    Footer
    Pagination is BROKEN (removing first post cuasing problems)
    Prettify
    Remove Sidebar
    Update Headers on all pages to be identical
        CSS Video Header

    Pagelist:
    - well set up index
    - Frontpage
    - About
    - Contact
    - 404
    - Privacy Policy


COMPLETED:
    --CSS image header

    -->


<?php
get_footer();

