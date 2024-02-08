<?php
/**
 * Template Name: Custom - Front Page
 *
 * The Frontpage of the PreLaunch Theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */

get_header(); ?>

    <video class="header-video" src="https://foothillscollective.com/wp-content/uploads/2021/04/Res-Power-Background.mp4" autoplay loop playsinline muted></video>

    <div class="viewport-header">
        <div class="head-container">
            <div class="center add-padding">
                <h1 class="text-white text-5xl pb-5">Header Title</h1>
            </div>
            <hr class="text-white pb-5">
            <h2 class="text-white text-3xl ">Title</h2>
            <h3 class="text-white text-2xl">Subtitle</h3>
        </div>
    </div>

    <div class="bg-white md:p-10">
        <div class=" lg:max-w-5xl lg:mx-auto">
            <div class="grid grid-cols-12 gap-4 md:gap-10">
                <div class="col-span-12 md:col-span-4">
                    <?php get_template_part( 'components/cards/_sample-card' ); ?>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <div class="prose">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid architecto error et laudantium molestiae odit tempora temporibus? Aliquid aspernatur aut autem dolore, enim minima molestias sapiente. Consectetur culpa nihil obcaecati?</div>
                </div>

                <div class="col-span-12 md:col-span-4 prose">
                    <h2>Header Line</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores earum magni nihil praesentium quam sequi sunt vitae. Excepturi iure molestias perferendis quidem, recusandae tempora. A hic nihil pariatur suscipit ut.</p>
                </div>
            </div>
        </div>
    </div>



<?php
get_footer();