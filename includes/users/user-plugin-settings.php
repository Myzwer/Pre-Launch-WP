<?php
	/**
	 * Plugin settings access rules for Prelaunch-managed roles.
	 *
	 * This module controls access to plugin-specific admin/settings pages that
	 * fall outside core WordPress feature areas.
	 *
	 * Supported policy levels:
	 * - full: leave all registered plugin settings pages available
	 * - approved_only: allow only explicitly approved plugin settings pages
	 * - off: hide/block all registered plugin settings pages
	 *
	 * How to find a plugin page slug for this registry:
	 * 1. Click the plugin's menu item in wp-admin.
	 * 2. Look at the URL:
	 *    - admin.php?page=example-slug  -> page slug is "example-slug"
	 *    - options-general.php?page=foo -> parent is "options-general.php", page slug is "foo"
	 *    - tools.php?page=bar           -> parent is "tools.php", page slug is "bar"
	 * 3. Add the plugin page to the registry below.
	 *
	 * Notes:
	 * - This module only governs pages registered in the local registry.
	 * - New plugins should be reviewed intentionally and added here if they
	 *   should be client-accessible.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the plugin-settings access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_plugin_settings_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'plugin_settings', 'off' );

		if ( ! is_string( $level ) ) {
			return 'off';
		}

		$allowed_levels = array(
			'full',
			'approved_only',
			'off',
		);

		return in_array( $level, $allowed_levels, true ) ? $level : 'off';
	}

	/**
	 * Get the registry of plugin settings pages controlled by this module.
	 *
	 * Each entry should define:
	 * - label: human-readable name for documentation/debugging
	 * - parent_slug: admin parent page slug
	 * - menu_slug: page slug used by WordPress
	 * - approved: whether the page is allowed in approved_only mode
	 *
	 * @return array<string, array<string, mixed>>
	 */
	function prelaunch_get_plugin_settings_registry(): array {
		return array(
			'filebird' => array(
				'label'       => 'FileBird',
				'parent_slug' => 'filebird-dashboard',
				'menu_slug'   => 'filebird-dashboard',
				'approved'    => true,
			),
			'tsf'      => array(
				'label'       => 'The SEO Framework',
				'parent_slug' => 'theseoframework-settings',
				'menu_slug'   => 'theseoframework-settings',
				'approved'    => false,
			),
		);
	}

	/**
	 * Get the plugin settings pages that should be hidden for the current policy.
	 *
	 * @param string $access_level Current access level.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	function prelaunch_get_hidden_plugin_settings_pages( string $access_level ): array {
		$registry = prelaunch_get_plugin_settings_registry();

		if ( 'full' === $access_level ) {
			return array();
		}

		$hidden_pages = array();

		foreach ( $registry as $page_config ) {
			if ( 'off' === $access_level ) {
				$hidden_pages[] = $page_config;
				continue;
			}

			if ( empty( $page_config['approved'] ) ) {
				$hidden_pages[] = $page_config;
			}
		}

		return $hidden_pages;
	}

	/**
	 * Clean up plugin settings menus for managed roles.
	 *
	 * @return void
	 */
	function prelaunch_customize_plugin_settings_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'plugin_settings', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		foreach ( prelaunch_get_hidden_plugin_settings_pages( $access_level ) as $page_config ) {
			$parent_slug = isset( $page_config['parent_slug'] ) ? (string) $page_config['parent_slug'] : '';
			$menu_slug   = isset( $page_config['menu_slug'] ) ? (string) $page_config['menu_slug'] : '';

			if ( '' === $menu_slug ) {
				continue;
			}

			remove_menu_page( $menu_slug );

			if ( '' !== $parent_slug ) {
				remove_submenu_page( $parent_slug, $menu_slug );
			}
		}
	}

	add_action( 'admin_menu', 'prelaunch_customize_plugin_settings_admin_menu', 1000 );

	/**
	 * Block direct access to hidden plugin settings pages.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_plugin_settings_admin_pages(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'plugin_settings', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) || '' === $pagenow ) {
			return;
		}

		$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		if ( ! is_string( $page ) || '' === $page ) {
			return;
		}

		foreach ( prelaunch_get_hidden_plugin_settings_pages( $access_level ) as $page_config ) {
			$menu_slug = isset( $page_config['menu_slug'] ) ? (string) $page_config['menu_slug'] : '';

			if ( $page !== $menu_slug ) {
				continue;
			}

			wp_die(
				esc_html__( 'You do not have access to this plugin settings page on this site.', 'prelaunch-wp' ),
				esc_html__( 'Access denied', 'prelaunch-wp' ),
				array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_plugin_settings_admin_pages' );
