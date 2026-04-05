<?php
/**
 * WYSIWYG Layout
 *
 * This file generates a simple WYSIWYG Editor for the site.
 * Needs a container around it to constrain it to a degree.
 *
 * REQUIRED ACF FIELDS:
 * generic_block (wysiwyg editor)
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

<div class="prose">
    <?php
    if(get_sub_field('generic_block')): the_sub_field('generic_block');
    elseif(get_field('generic_block')): get_field('generic_block');
    endif;
    ?>
</div>