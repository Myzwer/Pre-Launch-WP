<?php
/**
 * Text Block Template Partial
 *
 * This file contains the ACF and php code for use in the template builder (page.php).
 * Must be inside flex content, all of this code uses subfields. It won't work standalone.
 *
 * It generates a simplified WYSIWYG editor.
 *
 * Usage: get_template_part( 'components/blocks/text' );
 *
 * @package WordPress
 * @subpackage Bootcamp_2
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */
?>

<div class="p-5 mx-auto max-w-screen-2xl xl:p-5 xl:w-8/12">
    <div class="grid grid-cols-12 gap-4 md:gap-4">
        <div class="col-span-12 py-5 max-w-none prose-theme">
			<?php the_sub_field( "text_editor" ); ?>
        </div>
    </div>
</div>


