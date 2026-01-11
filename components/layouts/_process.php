<div class="text-black bg-white">
    <div class="relative bg-scroll bg-no-repeat bg-cover"
         style="background:
                 url('<?php echo get_template_directory_uri(); ?>/assets/src/img/image.png') center center;">
        <div class="py-10 px-10 md:py-20 md:px-0 lg:mx-auto lg:max-w-6xl">
            <div class="grid grid-cols-12 gap-4 md:gap-10">
                <div class="col-span-12 max-w-none prose prose-white">
                    <?php the_field('process_section'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

