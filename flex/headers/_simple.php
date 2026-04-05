<?php
/*
 * REQUIRED ACF FIELDS:
 * simple_title (text field)
 *
 * */
?>

<div class="bg-black">
    <div class="relative bg-scroll bg-no-repeat bg-cover"
         style="
                 height: 20vh;">
        <div class="text-center content-middle">
            <div class="center add-padding">
                <h2 class="text-xl font-bold text-white md:text-2xl lb-2"><?php the_sub_field( "small_subtitle" ); ?></h2>
            </div>
            <h1 class="text-3xl font-bold text-white uppercase md:text-5xl"><?php the_sub_field( "main_title" ); ?></h1>
        </div>
    </div>
</div>
