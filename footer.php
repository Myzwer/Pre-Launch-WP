<?php
	/**
	 * Theme Footer
	 *
	 * Determines which footer layout (simple or complex) should render based on
	 * the ACF Globals options page, then outputs the shared site credit bar.
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
	/*
	|--------------------------------------------------------------------------
	| Footer Credit Bar
	|--------------------------------------------------------------------------
	|
	| Shared sitewide footer bar shown beneath both footer layouts.
	| Displays copyright text, legal links, and optional agency credit.
	| Agency credit visibility is controlled in the ACF Globals options page.
	|
	*/

	$show_site_credit_bar = get_field( 'show_site_credit_bar', 'option' );
	$agency_credit_name   = trim( (string) get_field( 'agency_credit_name', 'option' ) );
	$agency_credit_url    = trim( (string) get_field( 'agency_credit_url', 'option' ) );

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

					<?php if ( $show_site_credit_bar && $agency_credit_name !== '' ) : ?>
						<span class="footer-credit-separator" aria-hidden="true">|</span>

						<span class="footer-credit-agency">
							Site by
							<?php if ( $agency_credit_url !== '' ) : ?>
								<a
									class="footer-credit-link footer-credit-link-agency"
									href="<?php echo esc_url( $agency_credit_url ); ?>"
									target="_blank"
									rel="noopener noreferrer"
								>
									<?php echo esc_html( $agency_credit_name ); ?>
								</a>
							<?php else : ?>
								<?php echo esc_html( $agency_credit_name ); ?>
							<?php endif; ?>
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
