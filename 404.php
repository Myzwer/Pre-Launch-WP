<?php
/**
 * Template Name: 404 Error
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */

get_header(); ?>

    <div class="grid grid-cols-12">
        <div class="col-span-12 text-center md:col-span-6">
            <div class="md:mx-10 md:text-left">
                <div class="mt-11 w-20">
                    <img src="https://images.squarespace-cdn.com/content/v1/575a6067b654f9b902f452f4/1552683653140-0UUVQSSUEWVC73AWAEQG/300Logo.png"
                         alt="Company Logo">
                </div>

                <p class="md:mt-10">404 Error</p>
                <h1 class="text-2xl uppercase md:mb-10 md:text-3xl">Page Not Found</h1>
                <p>The rocket took off without this page ¯\_(ツ)_/¯</p>
                <button class="py-4 px-8 my-6 mx-auto font-bold text-gray-800 bg-white rounded-full shadow-lg transition duration-300 ease-in-out transform lg:mx-0 hover:underline hover:scale-105 focus:outline-none focus:shadow-outline">
                    Back to Homepage
                </button>
            </div>
        </div>

        <div class="col-span-12 md:col-span-6">
            <div class="relative bg-scroll bg-no-repeat bg-cover" style="background: linear-gradient(
				  rgba(0, 0, 0, 0.45),
				  rgba(0, 0, 0, 0.45)
				), url('https://images.unsplash.com/photo-1501612780327-45045538702b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2100&q=80') center center;
				 height: 80vh;">
            </div>
        </div>
    </div>

<?php get_footer();
