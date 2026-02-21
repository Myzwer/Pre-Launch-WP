<?php
/*
 * REQUIRED ACF FIELDS:
 * small_subtitle (Text field)
 * main_title (text field)
 * primary_cta (group)
 *  - button_text (text field)
 *  - button_link (link field)
 * side_photo (image)
 *
 * */
?>


<div class="relative bg-media bg-overlay-45" style="--bg-image: url('<?php echo esc_url(get_sub_field('side_photo')); ?>'); height: 60vh;">
	<div class="px-5 text-center content-middle-medium text-pretty">
		<h2 class="text-xl font-bold text-white lg:text-2xl lb-2"><?php the_sub_field( "small_subtitle" ); ?></h2>
		<h1 class="text-3xl font-bold text-white uppercase lg:text-5xl"><?php the_sub_field( "main_title" ); ?></h1>
	</div>
</div>


