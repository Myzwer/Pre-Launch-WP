<?php
	/**
	 * WordPress Tools access rules for Prelaunch-managed roles.
	 *
	 * Supported policy levels:
	 * - on  : normal WordPress Tools access
	 * - off : remove Tools menu and block access
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the Tools access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_tools_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'tools', 'off' );

		if ( ! is_string( $level ) ) {
			return 'off';
		}

		return in_array( $level, array( 'on', 'off' ), true ) ? $level : 'off';
	}

	/**
	 * Capabilities controlled by the Tools module.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_tools_controlled_caps(): array {
		return array(
			'import',
			'export',
		);
	}

	/**
	 * Sync Tools capabilities for managed roles.
	 *
	 * @return void
	 */
	function prelaunch_sync_managed_role_tools_caps(): void {

		$controlled_caps = prelaunch_get_tools_controlled_caps();

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {

			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			foreach ( $controlled_caps as $cap ) {
				$role->remove_cap( $cap );
			}

			$access_level = prelaunch_get_tools_access_level( $role_slug );

			if ( 'on' === $access_level ) {
				foreach ( $controlled_caps as $cap ) {
					$role->add_cap( $cap );
				}
			}
		}
	}

	add_action( 'init', 'prelaunch_sync_managed_role_tools_caps', 30 );

	/**
	 * Remove Tools from admin menu when disabled.
	 *
	 * @return void
	 */
	function prelaunch_customize_tools_admin_menu(): void {

		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'tools', 'off' );

		if ( 'on' === $access_level ) {
			return;
		}

		global $menu;
		unset( $menu[75] ); // Tools menu

		/**
		 * Remove GDPR privacy tools that WordPress registers separately.
		 */
		remove_submenu_page( 'tools.php', 'export_personal_data' );
		remove_submenu_page( 'tools.php', 'erase_personal_data' );
	}

	add_action( 'admin_menu', 'prelaunch_customize_tools_admin_menu', 1000 );

	/**
	 * Block direct access to Tools pages.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_tools_admin_pages(): void {

		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'tools', 'off' );

		if ( 'on' === $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) ) {
			return;
		}

		$blocked_pages = array(
			'tools.php',
			'import.php',
			'export.php',
			'export_personal_data',
			'erase_personal_data',
		);

		if ( in_array( $pagenow, $blocked_pages, true ) ) {

			wp_die(
				esc_html__( 'You do not have access to the Tools section on this site.', 'prelaunch-wp' ),
				esc_html__( 'Access denied', 'prelaunch-wp' ),
				array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_tools_admin_pages' );
