<?php
	/**
	 * ACF access rules for Prelaunch-managed roles.
	 *
	 * Supported policy levels:
	 * - full: normal ACF access
	 * - options_only: allow ACF options pages, but hide/block ACF admin screens
	 * - off: hide/block all ACF admin screens and all registered ACF options pages
	 *
	 * Notes:
	 * - This module intentionally does not remove broad capabilities like
	 *   manage_options. It controls access by admin menu cleanup and screen guards.
	 * - In options_only mode, ACF options pages are left alone so client-facing
	 *   pages like "Globals" continue to work normally.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the ACF access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_acf_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'acf', 'off' );

		if ( ! is_string( $level ) ) {
			return 'off';
		}

		$allowed_levels = array(
			'full',
			'options_only',
			'off',
		);

		return in_array( $level, $allowed_levels, true ) ? $level : 'off';
	}

	/**
	 * Get all registered ACF options page slugs.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_registered_acf_options_page_slugs(): array {
		if ( ! function_exists( 'acf_get_options_pages' ) ) {
			return array();
		}

		$options_pages = acf_get_options_pages();

		if ( ! is_array( $options_pages ) ) {
			return array();
		}

		$slugs = array();

		foreach ( $options_pages as $options_page ) {
			if ( ! is_array( $options_page ) || empty( $options_page['menu_slug'] ) ) {
				continue;
			}

			$slugs[] = (string) $options_page['menu_slug'];
		}

		return array_values( array_unique( $slugs ) );
	}

	/**
	 * Remove the core ACF admin UI from the menu.
	 *
	 * This hides Field Groups and related ACF developer tools.
	 *
	 * @return void
	 */
	function prelaunch_remove_acf_admin_menu(): void {
		remove_menu_page( 'edit.php?post_type=acf-field-group' );
		remove_submenu_page( 'edit.php?post_type=acf-field-group', 'edit.php?post_type=acf-field-group' );
		remove_submenu_page( 'edit.php?post_type=acf-field-group', 'acf-tools' );
		remove_submenu_page( 'edit.php?post_type=acf-field-group', 'acf-settings' );
		remove_submenu_page( 'edit.php?post_type=acf-field-group', 'acf-updates' );
	}

	/**
	 * Clean up ACF-related admin menus for managed roles.
	 *
	 * - full: leave ACF as-is
	 * - options_only: hide ACF admin UI, leave all options pages visible
	 * - off: hide ACF admin UI and all registered ACF options pages
	 *
	 * @return void
	 */
	function prelaunch_customize_acf_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'acf', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		prelaunch_remove_acf_admin_menu();

		if ( 'off' !== $access_level ) {
			return;
		}

		foreach ( prelaunch_get_registered_acf_options_page_slugs() as $menu_slug ) {
			remove_menu_page( $menu_slug );
		}
	}

	add_action( 'admin_menu', 'prelaunch_customize_acf_admin_menu', 1000 );

	/**
	 * Determine whether the current request targets a registered ACF options page.
	 *
	 * @return string|null Returns the page slug if this is an ACF options page request.
	 */
	function prelaunch_get_requested_acf_options_page_slug(): ?string {
		if ( ! is_admin() ) {
			return null;
		}

		$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		if ( ! is_string( $page ) || '' === $page ) {
			return null;
		}

		return in_array( $page, prelaunch_get_registered_acf_options_page_slugs(), true ) ? $page : null;
	}

	/**
	 * Block direct access to restricted ACF admin screens.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_acf_admin_screens(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'acf', 'off' );

		if ( 'full' === $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) || '' === $pagenow ) {
			return;
		}

		if ( 'edit.php' === $pagenow ) {
			$post_type = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

			if ( 'acf-field-group' === $post_type ) {
				wp_die(
					esc_html__( 'You do not have access to the ACF admin area on this site.', 'prelaunch-wp' ),
					esc_html__( 'Access denied', 'prelaunch-wp' ),
					array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}
		}

		if ( in_array( $pagenow, array( 'post.php', 'post-new.php' ), true ) ) {
			$post_type = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

			if ( 'acf-field-group' === $post_type ) {
				wp_die(
					esc_html__( 'You do not have access to the ACF admin area on this site.', 'prelaunch-wp' ),
					esc_html__( 'Access denied', 'prelaunch-wp' ),
					array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}

			$post_id = filter_input( INPUT_GET, 'post', FILTER_VALIDATE_INT );

			if ( $post_id && 'acf-field-group' === get_post_type( $post_id ) ) {
				wp_die(
					esc_html__( 'You do not have access to the ACF admin area on this site.', 'prelaunch-wp' ),
					esc_html__( 'Access denied', 'prelaunch-wp' ),
					array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}
		}

		if ( 'admin.php' === $pagenow ) {
			$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

			if ( in_array( $page, array( 'acf-tools', 'acf-settings', 'acf-updates' ), true ) ) {
				wp_die(
					esc_html__( 'You do not have access to the ACF admin area on this site.', 'prelaunch-wp' ),
					esc_html__( 'Access denied', 'prelaunch-wp' ),
					array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}

			if ( 'off' !== $access_level ) {
				return;
			}

			$acf_options_page = prelaunch_get_requested_acf_options_page_slug();

			if ( $acf_options_page ) {
				wp_die(
					esc_html__( 'You do not have access to these settings pages on this site.', 'prelaunch-wp' ),
					esc_html__( 'Access denied', 'prelaunch-wp' ),
					array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}
		}
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_acf_admin_screens' );
