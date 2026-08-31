<?php
	/**
	 * Font loading.
	 *
	 * To update Google Fonts:
	 * 1. Choose fonts at https://fonts.google.com/.
	 * 2. Copy the full stylesheet URL from the generated `href`.
	 * 4. Replace the URL in `prelaunch_get_google_fonts_url()`.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * Get the Google Fonts stylesheet URL.
	 *
	 * @return string
	 */
	function prelaunch_get_google_fonts_url(): string {
		return 'https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap';
	}

	/**
	 * Enqueue Google Fonts.
	 *
	 * @return void
	 */
	function prelaunch_enqueue_fonts(): void {
		wp_enqueue_style(
			'prelaunch-google-fonts',
			prelaunch_get_google_fonts_url(),
			[],
			null
		);
	}

	add_action( 'wp_enqueue_scripts', 'prelaunch_enqueue_fonts' );

	/**
	 * Add resource hints for Google Fonts.
	 *
	 * @param array<int, string|array<string, string>> $urls Resource hint URLs.
	 * @param string $relation_type Resource hint relation type.
	 *
	 * @return array<int, string|array<string, string>>
	 */
	function prelaunch_google_fonts_resource_hints( array $urls, string $relation_type ): array {
		if ( 'preconnect' !== $relation_type ) {
			return $urls;
		}

		$urls[] = 'https://fonts.googleapis.com';

		$urls[] = [
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		];

		return $urls;
	}

	add_filter( 'wp_resource_hints', 'prelaunch_google_fonts_resource_hints', 10, 2 );
