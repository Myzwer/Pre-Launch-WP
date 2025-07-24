<video class="header-video" src="<?php the_field('video_background'); ?>" autoplay loop playsinline muted></video>

<div class="viewport-header">
    <div class="text-center p-5">
        <h1 class="text-white text-5xl pb-5"><?php the_field('title'); ?></h1>
        <h3 class="text-white text-2xl pb-10"><?php the_field('subtitle'); ?></h3>
        <?php
        if (have_rows('primary_cta_button')):
            while (have_rows('primary_cta_button')): the_row(); ?>
                <a href="<?php the_sub_field('button_link'); ?>" class="btn-main">
                    <i class="fa-sharp fa-solid fa-arrow-right"></i>
                    <?php the_sub_field('button_text'); ?>
                </a>

            <?php
            endwhile;
        endif;
        ?>
    </div>
</div>




