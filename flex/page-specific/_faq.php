<div class="text-white bg-black">
    <div class="py-10 mx-4 md:mx-10 lg:mx-auto lg:max-w-6xl">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                <div class="max-w-none prose prose-white">
                    <?php the_field('faq_title'); ?>
                </div>
            </div>

            <div class="col-span-12 -mt-5 max-w-none prose">
                <div class="faq-content">

                    <?php

                    if (have_rows('faq')):
                        while (have_rows('faq')) : the_row();
                            ?>

                            <details>
                                <summary class="tab-title">
                                    <?php the_sub_field('question'); ?>
                                </summary>
                                <div class="max-w-none prose tab-details">
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
