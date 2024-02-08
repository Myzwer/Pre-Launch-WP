<?php
/**
 * Sample Card Template Partial
 *
 * This file generates a card for use on the site. Its pretty straight forward, needs customization.
 * It's also going to fill whatever its parent container is, so make sure you set that when you link it.
 * You'll also have to make this dynamic via ACF.
 *
 *
 * Usage: get_template_part( 'components/cards/sample-card' );
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */
?>

<div class="bg-white mx-5 mb-8 bg-gray-light shadow-xl rounded-xl relative flex flex-col">
    <img class="rounded-t-lg" src="https://via.placeholder.com/500x300" alt="Event Brand">
    <div class="p-5 flex-grow">
        <h2 class="text-xl md:text-2xl font-bold capitalize">Card Title</h2>
        <h3 class="text-lg">Card Subtitle</h3>
        <p class="pb-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam libero vel nisl malesuada, vitae
            fermentum risus tincidunt.
        </p>
    </div>

    <div class="grid grid-cols-12 rounded-bl-xl">
        <div class="col-span-6 text-center bg-gray-dark rounded-bl-xl">
            <a class="block text-lg uppercase py-3 text-white font-bold" href="#">Register</a>
        </div>

        <div class="col-span-6 rounded-br-xl bg-gray-darkest text-white text-center">
            <a class="block text-lg uppercase py-3 font-bold" href="#">Learn More</a>
        </div>
    </div>
</div>
