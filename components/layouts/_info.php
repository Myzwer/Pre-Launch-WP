<div class="bg-white text-black p-10">
    <div class="lg:max-w-6xl lg:mx-auto">
        <div class="grid grid-cols-12 gap-4 md:gap-10 ">
            <div class="col-span-12 md:col-span-6">
                <div class="prose pb-10">
                    <?php the_field('paragraph'); ?>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 prose">
                <div class="info">
                    <?php
                    if (have_rows('info_list')):
                        while (have_rows('info_list')) : the_row();
                            ?>

                            <h3>>> <?php the_sub_field('title'); ?></h3>
                            <?php the_sub_field('copy'); ?>

                        <?php
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
