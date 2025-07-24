<div class="bg-black text-white">
    <div class="mx-4 md:mx-10 lg:max-w-6xl lg:mx-auto py-10">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                <div class="prose prose-white max-w-none">
                    <?php the_field('faq_title'); ?>
                </div>
            </div>

            <div class="col-span-12 -mt-5 prose max-w-none">
                <div class="faq-content">

                    <?php

                    if (have_rows('faq')):
                        while (have_rows('faq')) : the_row();
                            ?>

                            <details>
                                <summary class="tab-title">
                                    <?php the_sub_field('question'); ?>
                                </summary>
                                <div class="prose max-w-none tab-details">
                                    <?php the_sub_field('answer'); ?>
                                </div>
                            </details>
                        <?php
                        endwhile;
                    endif; ?>


                </div>
            </div>

        </div>
    </div>
</div>
