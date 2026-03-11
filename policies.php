<?php
	/**
	 * Template Name: Policy Page
	 *
	 *
	 * @docs https://codex.wordpress.org/Template_Hierarchy
	 */

	get_header(); ?>

	<div class="relative bg-scroll bg-no-repeat bg-cover" style="background: linear-gradient(
		rgba(0, 0, 0, 0.45),
		rgba(0, 0, 0, 0.45)
		), url('<?php the_field( 'header_image' ); ?>') center center;
		height: 40vh;">
		<div class="text-center text-white content-middle">
			<h1 class="mb-5 text-4xl font-bold"><?php echo the_title(); ?></h1>
		</div>
	</div>


	<div class="text-black bg-white wrap">
		<div class="grid-12">
			<div class="col-span-12 py-10 prose-theme">
				<?php the_field( 'policy' ); ?>
				Contact Email: <?php echo esc_html( get_option( 'admin_email' ) ); ?>
			</div>
		</div>
	</div>


<?php get_footer();
