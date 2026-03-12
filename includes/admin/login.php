<?php
	/**
	 * Login screen assets and branding.
	 */

	defined( 'ABSPATH' ) || exit;

	add_action( 'login_enqueue_scripts', 'prelaunch_enqueue_login_styles' );

	/**
	 * Enqueue custom login stylesheet and shared color tokens.
	 */
	function prelaunch_enqueue_login_styles(): void {
		$theme_version = wp_get_theme()->get( 'Version' );
		$colors        = prelaunch_get_brand_colors();

		$rel_path = '/assets/admin/login.css';
		$file     = get_theme_file_path( $rel_path );
		$ver      = file_exists( $file ) ? (string) filemtime( $file ) : $theme_version;

		wp_enqueue_style(
			'prelaunch-login',
			get_theme_file_uri( $rel_path ),
			[],
			$ver
		);

		$inline_css = sprintf(
			':root {
			--color-black: %1$s;
			--color-white: %2$s;
			--color-primary: %3$s;
			--color-secondary: %4$s;
			--color-soft-1: %5$s;
			--color-soft-2: %6$s;
			--color-primary-gradient-to: %7$s;
			--color-secondary-gradient-to: %8$s;
			--color-impact-gradient-to: %9$s;
		}',
			esc_html( $colors['black'] ),
			esc_html( $colors['white'] ),
			esc_html( $colors['primary'] ),
			esc_html( $colors['secondary'] ),
			esc_html( $colors['soft-1'] ),
			esc_html( $colors['soft-2'] ),
			esc_html( $colors['primary-gradient-to'] ),
			esc_html( $colors['secondary-gradient-to'] ),
			esc_html( $colors['impact-gradient-to'] )
		);

		wp_add_inline_style( 'prelaunch-login', $inline_css );
	}

	add_action( 'login_enqueue_scripts', 'prelaunch_login_logo_styles', 20 );

	/**
	 * Output custom login logo styles from theme options.
	 */
	function prelaunch_login_logo_styles(): void {
		$image = get_field( 'footer_logo', 'option' );

		if ( empty( $image['url'] ) ) {
			return;
		}

		$logo_url = esc_url_raw( $image['url'] );

		$inline_css = sprintf(
			'body.login h1 a { background-image: url("%1$s"); }',
			$logo_url
		);

		wp_add_inline_style( 'prelaunch-login', $inline_css );
	}

	add_filter( 'login_headerurl', 'prelaunch_login_header_url' );

	/**
	 * Point the login logo URL back to the site homepage.
	 */
	function prelaunch_login_header_url(): string {
		return home_url( '/' );
	}

	add_filter( 'login_headertext', 'prelaunch_login_header_text' );

	/**
	 * Use the option logo alt text when available, otherwise fall back to site name.
	 */
	function prelaunch_login_header_text(): string {
		$image = get_field( 'footer_logo', 'option' );

		if ( ! empty( $image['alt'] ) ) {
			return $image['alt'];
		}

		return get_bloginfo( 'name' );
	}
