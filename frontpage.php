<?php
	/**
	 * Template Name: Custom - Front Page
	 *
	 * The Frontpage of the PreLaunch Theme
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package WordPress
	 * @subpackage Pre_Launch_WP
	 * @author Josh Forrester <josh@onefortyfivedesign.com>
	 * @version 1.0.0
	 */

	get_header(); ?>

<?php //get_template_part('components/headers/_hero'); ?>

<?php //get_template_part('components/layouts/_highlight'); ?>

<?php //get_template_part('components/layouts/_info'); ?>

<?php //get_template_part('components/layouts/_side-image'); ?>

<?php //get_template_part('components/layouts/_process'); ?>

<?php //get_template_part('components/layouts/_faq'); ?>

<?php
	if ( function_exists( 'gravity_form' ) ) : ?>

		<div class="flex justify-center items-center p-10 min-h-screen bg-primary-gradient">
			<div class="p-8 w-full max-w-2xl bg-white rounded-xl shadow-xl">

				<?php
					gravity_form(
						1,      // Form ID
						false,  // Display title
						false,  // Display description
						false,  // Display inactive
						null,   // Field values
						false,   // Disable AJAX
						1,      // Tab index
						true   // Echo (false returns instead)
					);
				?>

			</div>
		</div>

	<?php endif; ?>

<?php
	get_footer();
