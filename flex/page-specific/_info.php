<div class="p-10 text-black bg-white">
    <div class="lg:mx-auto lg:max-w-6xl">
        <div class="grid grid-cols-12 gap-4 md:gap-10">
            <div class="col-span-12 md:col-span-6">
                <div class="pb-10 prose">
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
