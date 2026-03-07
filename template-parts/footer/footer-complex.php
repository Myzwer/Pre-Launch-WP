<?php
	/**
	 * Complex Footer
	 * --------------
	 * Multi-column footer with contact info, social icons,
	 * quick links, legal copy, and affiliation logos.
	 */

	$phone_number  = get_field( 'phone_number', 'option' );
	$email_address = get_field( 'email_address', 'option' );

	/* README:FOOTER_COMPLEX_SOCIAL_NETWORK_OVERRIDE
	   The complex footer excludes phone + email from the social grid
	   because they appear in the contact block above. Modify the
	   'networks' array here if additional platforms should appear. */
	$socials = windpeak_get_social_items(
		[
			'networks' => [
				'facebook',
				'instagram',
				'x',
				'youtube',
				'pinterest',
				'linkedin',
				'tiktok',
				'threads',
				'github',
				'website',
			],
		]
	);
?>

<div class="footer-complex">
	<div class="footer-complex-clamp">
		<div class="footer-complex-grid">

			<div class="footer-complex-main">
				<div class="footer-complex-main__inner">
					<div class="footer-complex-logo-wrap">
						<?php
							$image = get_field( 'footer_logo', 'option' );

							if ( ! empty( $image ) ) :
								?>
								<img
									class="footer-complex-logo"
									src="<?php echo esc_url( $image['url'] ); ?>"
									alt="<?php echo esc_attr( $image['alt'] ); ?>"
								/>
							<?php endif; ?>
					</div>

					<?php if ( ! empty( $phone_number ) || ! empty( $email_address ) ) : ?>
						<div class="footer-complex-contact">
							<h3 class="footer-complex-heading">Contact Us</h3>

							<div class="footer-complex-contact__list">
								<?php if ( ! empty( $phone_number ) ) : ?>
									<p class="footer-complex-contact__item">
										<span class="footer-complex-contact__icon" aria-hidden="true">
											<i class="fa-solid fa-phone"></i>
										</span>

										<a
											href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone_number ) ); ?>"
											class="footer-complex-contact__text"
										>
											<?php echo esc_html( $phone_number ); ?>
										</a>
									</p>
								<?php endif; ?>

								<?php if ( ! empty( $email_address ) ) : ?>
									<p class="footer-complex-contact__item">
										<span class="footer-complex-contact__icon" aria-hidden="true">
											<i class="fa-solid fa-envelope"></i>
										</span>

										<a
											href="mailto:<?php echo esc_attr( $email_address ); ?>"
											class="footer-complex-contact__text"
										>
											<?php echo esc_html( $email_address ); ?>
										</a>
									</p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $socials ) ) : ?>
						<div class="footer-complex-socials">
							<?php foreach ( $socials as $item ) : ?>
								<div class="footer-complex-social">
									<?php
										echo windpeak_render_social_icon(
											$item['network'],
											[
												'size'  => 'sm',
												'shape' => 'circle',
												'tab'   => 'Y',
												'color' => 'current',
											]
										);
									?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="footer-complex-side">
				<div class="footer-complex-side__top">
					<div class="footer-complex-links">
						<h3 class="footer-complex-heading">Quick Links</h3>

						<div class="footer-complex-links__grid">
							<?php
								if ( have_rows( 'footer_complex_links', 'option' ) ) :
									while ( have_rows( 'footer_complex_links', 'option' ) ) :
										the_row();

										$link            = get_sub_field( 'link' );

										if ( $link ) :
											$link_url = $link['url'];
											$link_title  = $link['title'];
											$link_target = $link['target'] ? $link['target'] : '_self';
											?>
											<div class="complex-primary-link">
												<a
													href="<?php echo esc_url( $link_url ); ?>"
													target="<?php echo esc_attr( $link_target ); ?>"
												>
													<?php echo esc_html( $link_title ); ?>
												</a>
											</div>
										<?php
										endif;
									endwhile;
								endif;
							?>
						</div>
					</div>

					<div class="footer-complex-legal footer-complex-legal--desktop">
						<h3 class="footer-complex-heading legal-heading">Legal Information</h3>

						<div class="prose-theme footer-complex-legal__prose">
							<?php the_field( 'footer_complex_legal', 'option' ); ?>
						</div>
					</div>
				</div>

				<div class="footer-complex-affiliations">
					<?php if ( get_field( 'footer_affiliations_heading', 'option' ) ) : ?>
						<h3 class="footer-complex-heading">
							<?php the_field( 'footer_affiliations_heading', 'option' ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( have_rows( 'footer_affiliation_logos', 'option' ) ) : ?>
						<div class="footer-affiliations-grid">
							<?php
								while ( have_rows( 'footer_affiliation_logos', 'option' ) ) :
									the_row();

									$logo = get_sub_field( 'logo' );
									$name = get_sub_field( 'name' );
									$link = get_sub_field( 'link' );

									if ( empty( $logo ) ) {
										continue;
									}

									$logo_url = ! empty( $logo['url'] ) ? $logo['url'] : '';
									$logo_alt = ! empty( $logo['alt'] ) ? $logo['alt'] : $name;

									if ( empty( $logo_url ) ) {
										continue;
									}
									?>
									<div class="footer-affiliations-item">
										<?php if ( $link ) : ?>
											<?php
											$link_url    = ! empty( $link['url'] ) ? $link['url'] : '';
											$link_target = ! empty( $link['target'] ) ? $link['target'] : '_self';
											$link_title  = ! empty( $link['title'] ) ? $link['title'] : $name;

											if ( $link_url ) :
												?>
												<a
													class="footer-affiliations-link"
													href="<?php echo esc_url( $link_url ); ?>"
													target="<?php echo esc_attr( $link_target ); ?>"
													aria-label="<?php echo esc_attr( $link_title ); ?>"
												>
													<img
														class="footer-affiliations-logo"
														src="<?php echo esc_url( $logo_url ); ?>"
														alt="<?php echo esc_attr( $logo_alt ); ?>"
														loading="lazy"
														decoding="async"
													/>
												</a>
											<?php endif; ?>
										<?php else : ?>
											<div class="footer-affiliations-link footer-affiliations-link--static">
												<img
													class="footer-affiliations-logo"
													src="<?php echo esc_url( $logo_url ); ?>"
													alt="<?php echo esc_attr( $logo_alt ); ?>"
													loading="lazy"
													decoding="async"
												/>
											</div>
										<?php endif; ?>
									</div>
								<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="footer-complex-legal footer-complex-legal--mobile">
					<h3 class="footer-complex-heading">Legal Information</h3>

					<div class="prose-theme footer-complex-legal__prose">
						<?php the_field( 'footer_complex_legal', 'option' ); ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php
	/**
	 * Footer Credit Bar
	 * -----------------
	 * Static compliance / utility bar shown beneath the complex footer.
	 *
	 * Editable:
	 * - Optional toggle to show/hide the agency credit text.
	 *
	 * Hard-coded:
	 * - Copyright format
	 * - Privacy Policy link
	 * - Accessibility link
	 * - Agency attribution
	 */

	$show_site_credit_bar = get_field( 'show_site_credit_bar', 'option' );
	// If you keep your original field name instead, use this:
	// $show_site_credit_bar = get_field( 'show_built_by_section', 'option' );

	$privacy_policy_url = get_privacy_policy_url();
	$accessibility_page = get_page_by_path( 'accessibility' );
	$accessibility_url  = $accessibility_page ? get_permalink( $accessibility_page ) : home_url( '/accessibility/' );
?>

<div class="footer-credit">
	<div class="footer-credit__clamp">
		<div class="footer-credit__grid">

			<div class="footer-credit__left">
				<p class="footer-credit__copy">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<?php bloginfo( 'name' ); ?>. All rights reserved.
				</p>
			</div>

			<div class="footer-credit__right">
				<nav class="footer-credit__nav" aria-label="Footer legal navigation">
					<?php if ( ! empty( $privacy_policy_url ) ) : ?>
						<a class="footer-credit__link" href="<?php echo esc_url( $privacy_policy_url ); ?>">
							Privacy Policy
						</a>
					<?php endif; ?>

					<span class="footer-credit__separator" aria-hidden="true">|</span>

					<?php if ( ! empty( $accessibility_url ) ) : ?>
						<a class="footer-credit__link" href="<?php echo esc_url( $accessibility_url ); ?>">
							Accessibility
						</a>
					<?php endif; ?>

					<?php if ( $show_site_credit_bar ) : ?>
						<span class="footer-credit__separator" aria-hidden="true">|</span>

						<span class="footer-credit__agency">
							Site by
							<a
								class="footer-credit__link footer-credit__link--agency"
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
