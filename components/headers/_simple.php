<?php
/**
 * Simple Header Partial
 *
 * This file generates a card for use on the site. Its pretty straight forward, needs customization.
 * It's also going to fill whatever its parent container is, so make sure you set that when you link it.
 * You'll also have to make this dynamic via ACF.
 *
 * REQUIRED ACF FIELDS:
 * simple_title (text field)
 *
 *
 * Usage: get_template_part( 'components/cards/_simple' );
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */
?>

<div class="bg-white-gradient">
    <div class="content-middle text-center">
        <h1 class="text-white text-3xl md:text-5xl font-bold uppercase">
            <?php
            // This enables simple_title to work regardless of its a top level field or a subfield in flex content
            if(get_sub_field('simple_title')): the_sub_field('simple_title');
            elseif(get_field('simple_title')): the_field('simple_title');
            endif;
            ?>
        </h1>
    </div>
</div>

<!--
Textured background?
<div class="bg-white-gradient">
    <div class="bg-no-repeat bg-scroll bg-cover relative"
         style="background:
                 url('<?php /*echo get_template_directory_uri(); */?>/assets/src/img/topography.png') center center;
                 height: 20vh;">
        <div class="content-middle text-center">
            <h1 class="text-white text-3xl md:text-5xl font-bold uppercase">
                <?php
/*                // This enables simple_title to work regardless of its a top level field or a subfield in flex content
                if(get_sub_field('simple_title')): the_sub_field('simple_title');
                elseif(get_field('simple_title')): the_field('simple_title');
                endif;
                */?>
            </h1>
        </div>
    </div>
</div>-->