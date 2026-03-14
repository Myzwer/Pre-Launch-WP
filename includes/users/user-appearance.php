<?php
	/**
	 * WordPress Appearance access rules for Prelaunch-managed roles.
	 *
	 * Supported policy levels:
	 * - full: keep normal Appearance access
	 * - menus_only: hide Appearance, expose nav menus only as "Navbar"
	 * - off: disable all Appearance access
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the Appearance access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_appearance_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'appearance', 'off' );

		if ( ! is_string( $level ) ) {
			return 'off';
		}

		$allowed_levels = array(
			'full',
			'menus_only',
			'off',
		);

		return in_array( $level, $allowed_levels, true ) ? $level : 'off';
	}

	/**
	 * Get the Appearance-related capabilities controlled by this module.
	 *
	 * Note: nav menus depend on edit_theme_options, so the menus_only policy
	 * keeps that capability while removing higher-risk theme capabilities.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_appearance_controlled_caps(): array {
		return array(
			'edit_theme_options',
			'switch_themes',
			'edit_themes',
			'install_themes',
			'update_themes',
			'delete_themes',
		);
	}

	/**
	 * Sync Appearance capabilities for all Prelaunch-managed roles.
	 *
	 * Roles are cloned from Administrator first, so this module removes every
	 * capability it owns before re-applying the correct policy level.
	 *
	 * @return void
	 */
	function prelaunch_sync_managed_role_appearance_caps(): void {
		$controlled_caps = prelaunch_get_appearance_controlled_caps();

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			foreach ( $controlled_caps as $cap ) {
				$role->remove_cap( $cap );
			}

			$access_level = prelaunch_get_appearance_access_level( $role_slug );

			switch ( $access_level ) {
				case 'full':
					foreach ( $controlled_caps as $cap ) {
						$role->add_cap( $cap );
					}
					break;

				case 'menus_only':
					$role->add_cap( 'edit_theme_options' );
					break;

				case 'off':
				default:
					break;
			}
		}
	}

	add_action( 'init', 'prelaunch_sync_managed_role_appearance_caps', 30 );

	/**
	 * Customize the Appearance admin menu for managed roles.
	 *
	 * - full: leave core Appearance menu as-is
	 * - menus_only: hide Appearance and add a top-level "Navbar" link
	 * - off: hide Appearance completely
	 *
	 * @return void
	 */
	function prelaunch_customize_appearance_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'appearance', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		remove_menu_page( 'themes.php' );

		if ( 'menus_only' !== $access_level ) {
			return;
		}

		add_menu_page(
			__( 'Navbar', 'prelaunch-wp' ),
			__( 'Navbar', 'prelaunch-wp' ),
			'edit_theme_options',
			'nav-menus.php',
			'',
			'dashicons-menu',
			61
		);
	}

	add_action( 'admin_menu', 'prelaunch_customize_appearance_admin_menu', 999 );

	/**
	 * Block direct wp-admin access to restricted Appearance screens.
	 *
	 * This prevents managed roles from manually navigating to theme-related
	 * screens by URL when the policy does not allow them.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_appearance_admin_screens(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'appearance', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) || '' === $pagenow ) {
			return;
		}

		$appearance_pages = array(
			'themes.php',
			'theme-install.php',
			'theme-editor.php',
			'custom-header.php',
			'custom-background.php',
			'widgets.php',
			'customize.php',
			'site-editor.php',
			'nav-menus.php',
		);

		if ( ! in_array( $pagenow, $appearance_pages, true ) ) {
			return;
		}

		if ( 'menus_only' === $access_level && 'nav-menus.php' === $pagenow ) {
			return;
		}

		wp_die(
			esc_html__( 'You do not have access to the Appearance area on this site.', 'prelaunch-wp' ),
			esc_html__( 'Access denied', 'prelaunch-wp' ),
			array(
				'response'  => 403,
				'back_link' => true,
			)
		);
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_appearance_admin_screens' );
