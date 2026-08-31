<?php
	/**
	 * WordPress plugin-management access rules for Prelaunch-managed roles.
	 *
	 * Supported policy levels:
	 * - full: full plugin-management access
	 * - manage_installed: can manage/update installed plugins, but cannot install,
	 *   delete, or edit plugin files
	 * - off: no plugin access
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the Plugins access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_plugins_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'plugins', 'off' );

		if ( ! is_string( $level ) ) {
			return 'off';
		}

		$allowed_levels = array(
			'full',
			'manage_installed',
			'off',
		);

		return in_array( $level, $allowed_levels, true ) ? $level : 'off';
	}

	/**
	 * Get all plugin-related capabilities controlled by this module.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_plugins_controlled_caps(): array {
		return array(
			'activate_plugins',
			'install_plugins',
			'update_plugins',
			'delete_plugins',
			'edit_plugins',
		);
	}

	/**
	 * Get the plugin capabilities allowed for the manage_installed level.
	 *
	 * This level can manage plugins already on the site, but cannot install,
	 * delete, or edit plugin files.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_plugins_manage_installed_caps(): array {
		return array(
			'activate_plugins',
			'update_plugins',
		);
	}

	/**
	 * Sync plugin-management capabilities for all Prelaunch-managed roles.
	 *
	 * Roles are cloned from Administrator first, so this module removes every
	 * capability it owns before re-applying the correct policy level.
	 *
	 * @return void
	 */
	function prelaunch_sync_managed_role_plugins_caps(): void {
		$controlled_caps = prelaunch_get_plugins_controlled_caps();

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			foreach ( $controlled_caps as $cap ) {
				$role->remove_cap( $cap );
			}

			$access_level = prelaunch_get_plugins_access_level( $role_slug );

			switch ( $access_level ) {
				case 'full':
					foreach ( $controlled_caps as $cap ) {
						$role->add_cap( $cap );
					}
					break;

				case 'manage_installed':
					foreach ( prelaunch_get_plugins_manage_installed_caps() as $cap ) {
						$role->add_cap( $cap );
					}
					break;

				case 'off':
				default:
					break;
			}
		}
	}

	add_action( 'init', 'prelaunch_sync_managed_role_plugins_caps', 30 );

	/**
	 * Clean up the Plugins admin menu for managed roles.
	 *
	 * - full: leave Plugins as-is
	 * - manage_installed: keep Plugins, remove Add New / Plugin Editor submenus
	 * - off: remove Plugins completely
	 *
	 * @return void
	 */
	function prelaunch_customize_plugins_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'plugins', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		if ( 'off' === $access_level ) {
			remove_menu_page( 'plugins.php' );

			return;
		}

		if ( 'manage_installed' === $access_level ) {
			remove_submenu_page( 'plugins.php', 'plugin-install.php' );
			remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
		}
	}

	add_action( 'admin_menu', 'prelaunch_customize_plugins_admin_menu', 999 );

	/**
	 * Block direct wp-admin access to restricted Plugins screens.
	 *
	 * This prevents managed roles from manually navigating to restricted
	 * plugin-management screens by URL.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_plugins_admin_screens(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'plugins', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) || '' === $pagenow ) {
			return;
		}

		$plugin_pages = array(
			'plugins.php',
			'plugin-install.php',
			'plugin-editor.php',
			'update.php',
			'update-core.php',
		);

		if ( ! in_array( $pagenow, $plugin_pages, true ) ) {
			return;
		}

		if ( 'off' === $access_level ) {
			wp_die(
				esc_html__( 'You do not have access to the Plugins area on this site.', 'prelaunch-wp' ),
				esc_html__( 'Access denied', 'prelaunch-wp' ),
				array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}

		if ( 'manage_installed' === $access_level ) {
			$blocked_pages = array(
				'plugin-install.php',
				'plugin-editor.php',
				'update-core.php',
			);

			if ( in_array( $pagenow, $blocked_pages, true ) ) {
				wp_die(
					esc_html__( 'You do not have access to this plugin-management screen on this site.', 'prelaunch-wp' ),
					esc_html__( 'Access denied', 'prelaunch-wp' ),
					array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}
		}
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_plugins_admin_screens' );
