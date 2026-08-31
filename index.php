<?php
	/**
	 * Fallback template.
	 *
	 * WordPress requires index.php. This ACF-first theme is not meant to render
	 * a generic fallback, so any query that lands here is sent home.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	wp_safe_redirect( home_url( '/' ), 302 );
	exit;
