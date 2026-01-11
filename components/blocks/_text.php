<?php
/**
 * Text Block Template Partial
 *
 * This file contains the ACF and php code for use in flex content. Use it as a base for other partials.
 * The code checks for both field and sub_field, so it will work as top level content or in flex content / repeaters.
 *
 * It generates a WYSIWYG editor.
 *
 * Usage: get_template_part( 'components/blocks/text' );
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */
?>

<div class="p-5 mx-auto max-w-screen-2xl xl:p-5 xl:w-8/12">
    <div class="grid grid-cols-12 gap-4 md:gap-4">
        <div class="col-span-12 py-5 max-w-none prose">
            <?php
            // Check if the code needs to use field (top level) or subfield (in flex content)
            if(get_sub_field("text_editor")): the_sub_field("text_editor");
            elseif(get_field("text_editor")): the_field("text_editor");
            endif;
            ?>
        </div>
    </div>
</div>


