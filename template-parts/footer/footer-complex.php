<?php
	/**
	 * Complex Footer
	 *
	 * Full footer layout used when the site needs more than the simple footer.
	 * Renders the footer logo, contact details, social icons, quick links,
	 * legal copy, and affiliation logos.
	 *
	 * This template is selected from the ACF Globals options page.
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

<div class="footer">
	<div class="footer-outer">
		<div class="footer-grid">

			<div class="footer-main">
				<div class="footer-main-inner">
					<div class="footer-logo-wrap">
						<?php
							$image = get_field( 'footer_logo', 'option' );

							if ( ! empty( $image ) ) :
								?>
								<img
									class="footer-logo"
									src="<?php echo esc_url( $image['url'] ); ?>"
									alt="<?php echo esc_attr( $image['alt'] ); ?>"
								/>
							<?php endif; ?>
					</div>

					<?php if ( ! empty( $phone_number ) || ! empty( $email_address ) ) : ?>
						<div class="footer-contact">
							<h3 class="footer-heading">Contact Us</h3>

							<div class="footer-contact-list">
								<?php if ( ! empty( $phone_number ) ) : ?>
									<p class="footer-contact-item">
										<span class="footer-contact-icon" aria-hidden="true">
											<i class="fa-solid fa-phone"></i>
										</span>

										<a
											href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone_number ) ); ?>"
											class="footer-contact-text"
										>
											<?php echo esc_html( $phone_number ); ?>
										</a>
									</p>
								<?php endif; ?>

								<?php if ( ! empty( $email_address ) ) : ?>
									<p class="footer-contact-item">
										<span class="footer-contact-icon" aria-hidden="true">
											<i class="fa-solid fa-envelope"></i>
										</span>

										<a
											href="mailto:<?php echo esc_attr( $email_address ); ?>"
											class="footer-contact-text"
										>
											<?php echo esc_html( $email_address ); ?>
										</a>
									</p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $socials ) ) : ?>
						<div class="footer-socials">
							<?php foreach ( $socials as $item ) : ?>
								<div class="footer-social">
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

			<div class="footer-side">
				<div class="footer-top">
					<div class="footer-links">
						<h3 class="footer-heading">Quick Links</h3>

						<div class="footer-links-grid">
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
											<div class="footer-link">
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

					<div class="footer-legal footer-legal-desktop">
						<h3 class="footer-heading">Legal Information</h3>

						<div class="prose-theme footer-prose">
							<?php the_field( 'footer_complex_legal', 'option' ); ?>
						</div>
					</div>
				</div>

				<div class="footer-affiliations">
					<?php if ( get_field( 'footer_affiliations_heading', 'option' ) ) : ?>
						<h3 class="footer-heading">
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
											<div class="footer-affiliations-link footer-affiliations-link-static">
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

				<div class="footer-legal footer-legal-mobile">
					<h3 class="footer-heading">Legal Information</h3>

					<div class="prose-theme footer-prose">
						<?php the_field( 'footer_complex_legal', 'option' ); ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
