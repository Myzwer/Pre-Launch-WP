<?php
/**
 * Image + Text Block Template Partial
 *
 * This file contains the ACF and php code for use in the template builder (page.php).
 * Must be inside flex content, all of this code uses subfields. It won't work standalone.
 *
 * It generates a simplified WYSIWYG editor underneath an image banner.
 *
 * Usage: get_template_part( 'components/blocks/image-text' );
 *
 * @package WordPress
 * @subpackage Bootcamp_2
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 *
 */
?>


<div class="p-5 mx-auto max-w-screen-2xl xl:p-5 xl:w-8/12">
    <div class="grid grid-cols-12 gap-4 md:gap-4">
        <div class="col-span-12 py-5 mx-auto text-center">
			<?php
			$imageBanner = get_sub_field( "image_banner" );
			if ( ! empty( $imageBanner ) ): ?>
                <img class="rounded-xl shadow-xl" src="<?php echo esc_url( $imageBanner['url'] ); ?>"
                     alt="<?php echo esc_attr( $imageBanner['alt'] ); ?>">
			<?php endif; ?>
        </div>

        <div class="col-span-12 py-5 max-w-none prose text-pretty">
			<?php the_sub_field( "text_editor" ); ?>
        </div>
    </div>
</div>

