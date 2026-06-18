<?php

	/**
	 * Menu registration
	 *
	 * Registers the theme’s navigation menu locations and loads the custom
	 * nav walker used by the primary site navigation.
	 *
	 * Menu location IDs are referenced directly in templates. Renaming them
	 * will require updating the corresponding wp_nav_menu() calls.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/navigation-menus/
	 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
	 */

	declare( strict_types=1 );

	/**
	 * Load the custom nav walker used for the primary navigation.
	 */
	require_once __DIR__ . '/nav_walker.php';

	/**
	 * Register theme menu locations.
	 */
	function windpeak_register_menus(): void {
		register_nav_menus( [
			// Main site navigation.
			'primary-nav' => __( 'Primary Navigation', 'windpeak' ),
		] );
	}

	add_action( 'init', 'windpeak_register_menus' );
