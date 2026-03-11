<?php
	/**
	 * 404 template.
	 *
	 * @link https://codex.wordpress.org/Template_Hierarchy
	 */

	get_header();
?>

	<main class="error-404 not-found">
		<section class="error-404__section">
			<div class="error-404__blob error-404__blob--one" aria-hidden="true"></div>
			<div class="error-404__blob error-404__blob--two" aria-hidden="true"></div>
			<div class="error-404__blob error-404__blob--three" aria-hidden="true"></div>
			<div class="error-404__blob error-404__blob--four" aria-hidden="true"></div>
			<div class="error-404__blob error-404__blob--five" aria-hidden="true"></div>

			<div class="wrap">
				<div class="error-404__inner">
					<p class="error-404__code" aria-hidden="true">404</p>

					<div class="error-404__content prose-theme">
						<?php
							$main_text = get_field( 'main_text', 'option' );

							if ( $main_text ) {
								echo wp_kses_post( $main_text );
							} else {
								?>
								<h1>Page not found</h1>
								<p>Looks like this page wandered off. Head back home and we’ll get you pointed in the
									right direction.</p>
								<p><a class="btn_main" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home</a>
								</p>
								<?php
							}
						?>
					</div>
				</div>
			</div>
		</section>
	</main>

<?php get_footer();
