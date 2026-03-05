<?php
	/**
	 * Complex Footer
	 * --------------
	 * Displays footer logo only (baseline test).
	 */

	$logo_id = get_field( 'footer_logo', 'option' );

	if ( ! $logo_id ) {
		$logo_id = get_theme_mod( 'custom_logo' ); // fallback to site logo
	}

	if ( $logo_id ) {
		echo wp_get_attachment_image(
			$logo_id,
			'full',
			false,
			[
				'alt' => esc_attr( get_bloginfo( 'name' ) ),
			]
		);
	}
?>
complex
