<?php
	/**
	 * WordPress Settings access rules for Prelaunch-managed roles.
	 *
	 * Supported policy levels:
	 * - full: normal WordPress Settings access
	 * - off: hide the Settings menu and block core WordPress settings screens
	 *
	 * Important:
	 * This module intentionally does not remove the manage_options capability.
	 * Many plugins rely on that capability for their own admin pages, so this
	 * module only controls the core WordPress Settings area.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the Settings access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_settings_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'settings', 'off' );

		if ( ! is_string( $level ) ) {
			return 'off';
		}

		return in_array( $level, array( 'full', 'off' ), true ) ? $level : 'off';
	}

	/**
	 * Hide the core Settings menu when disabled.
	 *
	 * This is UI cleanup only. Capability mutation is intentionally avoided so
	 * plugin admin pages that rely on manage_options continue to work.
	 *
	 * @return void
	 */
	function prelaunch_customize_settings_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'settings', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		global $menu;

		/**
		 * Settings menu index in WordPress.
		 */
		unset( $menu[80] );
	}

	add_action( 'admin_menu', 'prelaunch_customize_settings_admin_menu', 1000 );

	/**
	 * Block direct access to core WordPress Settings screens.
	 *
	 * This protects against direct URL access while still preserving
	 * manage_options for plugin compatibility.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_settings_admin_pages(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'settings', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) ) {
			return;
		}

		$blocked_pages = array(
			'options-general.php',
			'options-writing.php',
			'options-reading.php',
			'options-discussion.php',
			'options-media.php',
			'options-permalink.php',
			'options-privacy.php',
		);

		if ( in_array( $pagenow, $blocked_pages, true ) ) {
			wp_die(
				esc_html__( 'You do not have access to the Settings area on this site.', 'prelaunch-wp' ),
				esc_html__( 'Access denied', 'prelaunch-wp' ),
				array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_settings_admin_pages' );
