<?php
	/**
	 * Theme Footer
	 *
	 * Loads the footer layout selected in the ACF Globals options page,
	 * then renders the shared footer credit bar beneath it.
	 */

	$layout = get_field( 'footer_layout', 'option' ) ?: 'simple';

	switch ( $layout ) {
		case 'complex':
			get_template_part( 'template-parts/footer/footer', 'complex' );
			break;

		case 'simple':
		default:
			get_template_part( 'template-parts/footer/footer', 'simple' );
			break;
	}
?>

<?php
	/**
	 * Footer Credit Bar
	 *
	 * Shared sitewide footer bar shown beneath both footer layouts.
	 * Displays copyright text, legal links, and optional agency credit.
	 *
	 * Agency credit visibility is controlled in the ACF Globals options page.
	 */

	$show_site_credit_bar = get_field( 'show_site_credit_bar', 'option' );
	// If you keep your original field name instead, use this:
	// $show_site_credit_bar = get_field( 'show_built_by_section', 'option' );

	$privacy_policy_url = get_privacy_policy_url();
	$accessibility_page = get_page_by_path( 'accessibility' );
	$accessibility_url  = $accessibility_page ? get_permalink( $accessibility_page ) : home_url( '/accessibility/' );
?>

<div class="footer-credit">
	<div class="footer-credit-outer">
		<div class="footer-credit-grid">

			<div class="footer-credit-left">
				<p class="footer-credit-copy">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<?php bloginfo( 'name' ); ?>. All rights reserved.
				</p>
			</div>

			<div class="footer-credit-right">
				<nav class="footer-credit-nav" aria-label="Footer legal navigation">
					<?php if ( ! empty( $privacy_policy_url ) ) : ?>
						<a class="footer-credit-link" href="<?php echo esc_url( $privacy_policy_url ); ?>">
							Privacy Policy
						</a>
					<?php endif; ?>

					<span class="footer-credit-separator" aria-hidden="true">|</span>

					<?php if ( ! empty( $accessibility_url ) ) : ?>
						<a class="footer-credit-link" href="<?php echo esc_url( $accessibility_url ); ?>">
							Accessibility
						</a>
					<?php endif; ?>

					<?php if ( $show_site_credit_bar ) : ?>
						<span class="footer-credit-separator" aria-hidden="true">|</span>

						<span class="footer-credit-agency">
							Site by
							<a
								class="footer-credit-link footer-credit-link-agency"
								href="https://windpeakdesign.com/"
								target="_blank"
								rel="noopener noreferrer"
							>
								Windpeak Design
							</a>
						</span>
					<?php endif; ?>
				</nav>
			</div>

		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
