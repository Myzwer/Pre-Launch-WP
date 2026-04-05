<?php
	/**
	 * The Default template file - Page Builder
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package WordPress
	 * @subpackage Pre_Launch_WP
	 * @author Josh Forrester <josh@onefortyfivedesign.com>
	 * @version 1.0.0
	 */

	get_header(); ?>

<?php
// Check value exists.
	if ( have_rows( 'header_select' ) ) :

		// Loop through rows.
		while ( have_rows( 'header_select' ) ) : the_row();

			switch ( get_row_layout() ) {
				case 'simple_header':
//                get_template_part('components/headers/flexy/_simple');
					break;

				case 'button_header':
//                get_template_part('components/headers/flexy/_button');
					break;

				case 'image_header':
//                get_template_part('components/headers/flexy/_image');
					break;

				default:
					error_log( 'Unhandled content block: ' . get_row_layout() );
					break;
			}

		endwhile;
	endif;
?>


<?php
// Check value exists.
	if ( have_rows( 'body_sections' ) ) :

		echo "<div class='alt-bg-wrap'>"; // Wrap the entire section

		// Loop through rows.
		while ( have_rows( 'body_sections' ) ) : the_row();

			echo "<div class='bg-alternating-gradient'>";

			switch ( get_row_layout() ) {
				case 'text_block':
//                get_template_part('components/blocks/flexy/_text');
					break;

				case 'image_banner_text':
//                get_template_part('components/blocks/flexy/_image-text');
					break;

				default:
					error_log( 'Unhandled content block: ' . get_row_layout() );
					break;
			}

			echo '</div>';

			// End loop.
		endwhile;

		echo '</div>';

	endif;
?>

<?php get_footer();
