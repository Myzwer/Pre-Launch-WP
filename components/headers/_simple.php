<?php
/**
 * Simple Header Partial
 *
 * This file generates a card for use on the site. Its pretty straight forward, needs customization.
 * It's also going to fill whatever its parent container is, so make sure you set that when you link it.
 * You'll also have to make this dynamic via ACF.
 *
 * REQUIRED ACF FIELDS:
 * simple_title (text field)
 *
 *
 * Usage: get_template_part( 'components/cards/_simple' );
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */
?>

<div class="bg-white-gradient">
    <div class="text-center content-middle">
        <h1 class="text-3xl font-bold text-white uppercase md:text-5xl">
            <?php
            // This enables simple_title to work regardless of its a top level field or a subfield in flex content
            if(get_sub_field('simple_title')): the_sub_field('simple_title');
            elseif(get_field('simple_title')): the_field('simple_title');
            endif;
            ?>
        </h1>
    </div>
</div>


<?php
// Textured background
$texture = get_field('textured_image', 'option');
$texture_url = is_array($texture) ? ($texture['url'] ?? '') : $texture; // supports return: array or url
?>

<div class="bg-secondary-gradient">
	<div
		class="relative bg-texture"
		style="<?php echo $texture_url ? '--bg-texture: url(\'' . esc_url($texture_url) . '\');' : ''; ?> height: 20vh;"
	>
		<div class="text-center content-middle">
			<h1 class="text-3xl font-bold text-black uppercase md:text-5xl">
				<?php echo $texture ?>
			</h1>
		</div>
	</div>
</div>
