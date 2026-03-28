<?php
	/**
	 * WordPress Dashboard access rules for Prelaunch-managed roles.
	 *
	 * This module controls visibility and access to the core wp-admin dashboard.
	 * When dashboard access is disabled, managed users are redirected to
	 * "My Profile" because that screen is guaranteed to remain available.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Determine whether a managed role should have access to the Dashboard.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return bool
	 */
	function prelaunch_role_has_dashboard_access( string $role_slug ): bool {
		return prelaunch_role_has_feature_access( $role_slug, 'dashboard' );
	}

	/**
	 * Remove the Dashboard admin menu for managed users when disabled.
	 *
	 * @return void
	 */
	function prelaunch_maybe_hide_dashboard_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		if ( prelaunch_current_user_has_feature_access( 'dashboard' ) ) {
			return;
		}

		remove_menu_page( 'index.php' );
	}

	add_action( 'admin_menu', 'prelaunch_maybe_hide_dashboard_admin_menu', 999 );

	/**
	 * Redirect managed users away from the Dashboard when it is disabled.
	 *
	 * @return void
	 */
	function prelaunch_maybe_redirect_dashboard_screen(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		if ( prelaunch_current_user_has_feature_access( 'dashboard' ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( ! $screen || 'dashboard' !== $screen->id ) {
			return;
		}

		wp_safe_redirect( admin_url( 'profile.php' ) );
		exit;
	}

	add_action( 'current_screen', 'prelaunch_maybe_redirect_dashboard_screen' );

	/**
	 * Redirect managed users to My Profile immediately after login when the
	 * Dashboard is disabled and no explicit redirect was requested.
	 *
	 * @param string $redirect_to Redirect destination.
	 * @param string $requested_redirect_to Requested redirect.
	 * @param WP_User|WP_Error $user Authenticated user object.
	 *
	 * @return string
	 */
	function prelaunch_maybe_redirect_managed_user_login_to_profile(
		string $redirect_to,
		string $requested_redirect_to,
		$user
	): string {
		if ( ! $user instanceof WP_User ) {
			return $redirect_to;
		}

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			if ( ! prelaunch_user_has_role( $user, $role_slug ) ) {
				continue;
			}

			if ( prelaunch_role_has_dashboard_access( $role_slug ) ) {
				return $redirect_to;
			}

			if ( '' !== $requested_redirect_to ) {
				return $redirect_to;
			}

			return admin_url( 'profile.php' );
		}

		return $redirect_to;
	}

	add_filter( 'login_redirect', 'prelaunch_maybe_redirect_managed_user_login_to_profile', 10, 3 );
