<?php
	/**
	 * Simple Footer
	 * -------------
	 * Layout:
	 *  - Logo (center)
	 *  - Footer links (center)
	 *  - Social icons (center, wraps; 4 across on mobile)
	 *  - Legal text (center)
	 *  - Privacy Policy (center)
	 *
	 * ACF Options fields:
	 *  - footer_logo (optional override)
	 *  - footer_simple_links (repeater: link)
	 *  - footer_simple_legal_text (textarea)
	 *
	 * Social/contact fields are pulled from existing Globals fields (no new fields).
	 */

	$logo_id = get_field( 'footer_logo', 'option' );
	if ( ! $logo_id ) {
		$logo_id = get_theme_mod( 'custom_logo' ); // fallback to site logo
	}

	// Social field map (matches your Globals field names)
	$socials = [
		'facebook'  => [ 'field' => 'facebook_url', 'icon' => 'fa-brands fa-facebook', 'label' => 'Facebook' ],
		'instagram' => [ 'field' => 'instagram_url', 'icon' => 'fa-brands fa-instagram', 'label' => 'Instagram' ],
		'x'         => [ 'field' => 'x_url', 'icon' => 'fa-brands fa-x-twitter', 'label' => 'X' ],
		'threads'   => [ 'field' => 'threads_url', 'icon' => 'fa-brands fa-threads', 'label' => 'Threads' ],
		'tiktok'    => [ 'field' => 'tiktok_url', 'icon' => 'fa-brands fa-tiktok', 'label' => 'TikTok' ],
		'youtube'   => [ 'field' => 'youtube_url', 'icon' => 'fa-brands fa-youtube', 'label' => 'YouTube' ],
		'pinterest' => [ 'field' => 'pinterest_url', 'icon' => 'fa-brands fa-pinterest', 'label' => 'Pinterest' ],
		'linkedin'  => [ 'field' => 'linkedin_url', 'icon' => 'fa-brands fa-linkedin', 'label' => 'LinkedIn' ],
		'github'    => [ 'field' => 'github_url', 'icon' => 'fa-brands fa-github', 'label' => 'GitHub' ],
		'website'   => [ 'field' => 'website_url', 'icon' => 'fa-solid fa-globe', 'label' => 'Website' ],
		'email'     => [ 'field' => 'email_address', 'icon' => 'fa-solid fa-envelope', 'label' => 'Email' ],
		'phone'     => [ 'field' => 'phone_number', 'icon' => 'fa-solid fa-phone', 'label' => 'Phone' ],
	];

	// Build enabled socials (only those with values)
	$enabled_socials = [];
	foreach ( $socials as $key => $cfg ) {
		$val = get_field( $cfg['field'], 'option' );
		if ( is_string( $val ) && trim( $val ) !== '' ) {
			$enabled_socials[ $key ] = $cfg;
		}
	}

	// Privacy Policy URL (WP core)
	$privacy_url = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';

	// Legal text
	$legal = get_field( 'footer_simple_legal_text', 'option' );
	$legal = is_string( $legal ) ? trim( $legal ) : '';
?>

<footer class="py-12 section bg-secondary theme-invert">
	<div class="wrap">
		<!-- Grid-first, but tighter vertical rhythm than .grid-12 -->
		<div class="grid grid-cols-12 gap-x-4 gap-y-4 md:gap-x-10">

			<!-- Logo -->
			<?php if ( $logo_id ): ?>
				<div class="grid col-span-12 place-items-center">
					<div class="w-[220px] sm:w-[150px]">
						<?php
							echo wp_get_attachment_image(
								$logo_id,
								'full',
								false,
								[
									'class' => 'w-full h-auto',
									'alt'   => esc_attr( get_bloginfo( 'name' ) ),
								]
							);
						?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Links (optional) -->
			<?php if ( have_rows( 'footer_simple_links', 'option' ) ): ?>
				<div class="grid col-span-12 place-items-center">
					<ul class="grid gap-3 text-center">
						<?php while ( have_rows( 'footer_simple_links', 'option' ) ): the_row(); ?>
							<?php $link = get_sub_field( 'link' ); ?>
							<?php if ( ! empty( $link ) && is_array( $link ) && ! empty( $link['url'] ) && ! empty( $link['title'] ) ): ?>
								<li>
									<a
										class="font-semibold rounded-sm transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-secondary"
										href="<?php echo esc_url( $link['url'] ); ?>"
										<?php if ( ! empty( $link['target'] ) ): ?>
											target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"
										<?php endif; ?>
									>
										<?php echo esc_html( $link['title'] ); ?>
									</a>
								</li>
							<?php endif; ?>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php endif; ?>

			<!-- Social Icons (optional) -->
			<?php if ( ! empty( $enabled_socials ) ): ?>
				<div class="grid col-span-12 place-items-center">
					<div
						class="grid grid-cols-4 gap-4 place-items-center sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10">
						<?php foreach ( $enabled_socials as $key => $cfg ): ?>
							<?php
							$value = trim( (string) get_field( $cfg['field'], 'option' ) );
							$href  = '';

							if ( $key === 'email' ) {
								$email = sanitize_email( $value );
								$href  = $email ? 'mailto:' . $email : '';
							} elseif ( $key === 'phone' ) {
								// Basic tel normalize: keep digits and leading +
								$tel  = preg_replace( '/(?!^\+)[^\d]/', '', $value );
								$tel  = preg_replace( '/^\+?(\d.*)$/', '+$1', (string) $tel );
								$href = ( strlen( (string) $tel ) >= 8 ) ? 'tel:' . $tel : '';
							} else {
								$href = $value;
							}
							?>

							<?php if ( $href ): ?>
								<a
									class="grid place-items-center w-11 h-11 bg-white rounded-full transition sm:w-12 sm:h-12 hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 text-secondary focus-visible:ring-offset-secondary"
									href="<?php echo esc_url( $href ); ?>"
									<?php if ( $key !== 'email' && $key !== 'phone' ): ?>
										target="_blank" rel="noopener noreferrer"
									<?php endif; ?>
									aria-label="<?php echo esc_attr( $cfg['label'] ); ?>"
								>
									<i class="<?php echo esc_attr( $cfg['icon'] ); ?> text-xl sm:text-2xl"
									   aria-hidden="true"></i>
								</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Legal text (optional) -->
			<?php if ( $legal !== '' ): ?>
				<div class="grid col-span-12 place-items-center pt-2 text-center">
					<div class="text-base leading-relaxed">
						<?php
							// If they used <br> or simple tags, allow safe HTML. Otherwise preserve line breaks.
							if ( strpos( $legal, '<' ) !== false ) {
								echo wp_kses_post( $legal );
							} else {
								echo nl2br( esc_html( $legal ) );
							}
						?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Privacy Policy -->
			<?php if ( ! empty( $privacy_url ) ): ?>
				<div class="grid col-span-12 place-items-center text-center">
					<a
						class="rounded-sm transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-secondary"
						href="<?php echo esc_url( $privacy_url ); ?>"
					>
						Privacy Policy
					</a>
				</div>
			<?php endif; ?>

		</div>
	</div>
</footer>
