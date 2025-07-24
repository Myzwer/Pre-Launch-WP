<div class="bg-white text-black">
    <div class="bg-no-repeat bg-scroll bg-cover relative"
         style="background:
                 url('<?php echo get_template_directory_uri(); ?>/assets/src/img/image.png') center center;">
        <div class="lg:max-w-6xl lg:mx-auto px-10 py-10 md:px-0 md:py-20">
            <div class="grid grid-cols-12 gap-4 md:gap-10">
                <div class="col-span-12 prose prose-white max-w-none">
                    <?php the_field('process_section'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

