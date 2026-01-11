<video class="header-video" src="<?php the_field('video_background'); ?>" autoplay loop playsinline muted></video>

<div class="viewport-header">
    <div class="p-5 text-center">
        <h1 class="pb-5 text-5xl text-white"><?php the_field('title'); ?></h1>
        <h3 class="pb-10 text-2xl text-white"><?php the_field('subtitle'); ?></h3>
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




