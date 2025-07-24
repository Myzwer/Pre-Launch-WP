<div class="bg-black text-white p-10">
    <div class="lg:max-w-6xl lg:mx-auto">
        <div class="grid grid-cols-12 gap-4 md:gap-10 ">
            <div class="col-span-12 md:col-span-5">
                <div class="prose pb-10">
                    <?php
                    $bioimage = get_field("bio_image");
                    if (!empty($bioimage)): ?>
                        <img class="rounded-xl shadow-xl" src="<?php echo esc_url($bioimage['url']); ?>"
                             alt="<?php echo esc_attr($bioimage['alt']); ?>">
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-span-12 md:col-span-7 prose icons">
                <?php the_field('bio'); ?>
            </div>
        </div>
    </div>
</div>
