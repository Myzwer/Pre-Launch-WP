<?php
	/**
	 * Prelaunch custom role registration.
	 *
	 * Registers and syncs Prelaunch-managed roles.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Core WordPress administrator role slug.
	 */
	const PRELAUNCH_OWNER_ROLE = 'administrator';

	/**
	 * Client-facing admin role slug.
	 */
	const PRELAUNCH_CLIENT_ADMIN_ROLE = 'prelaunch_client_admin';

	/**
	 * Developer-only capability for the Tokens options page.
	 *
	 * This is intentionally separate from broad core capabilities such as
	 * manage_options so developer-only settings remain private even when a
	 * managed role retains access to plugin settings pages that depend on
	 * manage_options.
	 */
	const PRELAUNCH_MANAGE_TOKENS_CAP = 'prelaunch_manage_tokens';

	/**
	 * Get all Prelaunch-managed role slugs.
	 *
	 * This allows future modules to target all managed roles from one place.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_managed_user_roles(): array {
		return array(
			PRELAUNCH_CLIENT_ADMIN_ROLE,
		);
	}

	/**
	 * Determine whether a user has a specific role.
	 *
	 * @param WP_User|null $user User object. Defaults to current user.
	 * @param string $role_slug Role slug to check.
	 *
	 * @return bool
	 */
	function prelaunch_user_has_role( ?WP_User $user, string $role_slug ): bool {
		if ( ! $user instanceof WP_User ) {
			return false;
		}

		return in_array( $role_slug, (array) $user->roles, true );
	}

	/**
	 * Determine whether the current user is the Prelaunch client admin role.
	 *
	 * @return bool
	 */
	function prelaunch_is_client_admin(): bool {
		return prelaunch_user_has_role( wp_get_current_user(), PRELAUNCH_CLIENT_ADMIN_ROLE );
	}

	/**
	 * Determine whether the current user has any Prelaunch-managed role.
	 *
	 * @return bool
	 */
	function prelaunch_current_user_has_managed_role(): bool {
		$user = wp_get_current_user();

		if ( ! $user instanceof WP_User ) {
			return false;
		}

		return (bool) array_intersect( prelaunch_get_managed_user_roles(), (array) $user->roles );
	}

	/**
	 * Register or sync the Prelaunch client admin role.
	 *
	 * Creates a "Site Administrator" role using the default Administrator
	 * capabilities. If the role already exists, any missing Administrator
	 * capabilities are added so the role stays in sync with plugin-added caps.
	 *
	 * @return void
	 */
	function prelaunch_register_client_admin_role(): void {
		$admin_role = get_role( PRELAUNCH_OWNER_ROLE );

		if ( ! $admin_role ) {
			return;
		}

		$client_role = get_role( PRELAUNCH_CLIENT_ADMIN_ROLE );

		if ( ! $client_role ) {
			add_role(
				PRELAUNCH_CLIENT_ADMIN_ROLE,
				__( 'Site Administrator', 'prelaunch-wp' ),
				$admin_role->capabilities
			);

			$client_role = get_role( PRELAUNCH_CLIENT_ADMIN_ROLE );
		}

		if ( ! $client_role ) {
			return;
		}

		foreach ( $admin_role->capabilities as $cap => $grant ) {
			if ( $grant ) {
				$client_role->add_cap( $cap );
			}
		}
	}

	add_action( 'init', 'prelaunch_register_client_admin_role', 20 );

	/**
	 * Sync developer-only capabilities.
	 *
	 * The true Administrator role keeps developer-only capabilities, while all
	 * Prelaunch-managed roles explicitly lose them. This is important because
	 * managed roles are cloned from Administrator and would otherwise inherit
	 * these capabilities automatically.
	 *
	 * @return void
	 */
	function prelaunch_sync_developer_caps(): void {
		$admin_role = get_role( PRELAUNCH_OWNER_ROLE );

		if ( $admin_role ) {
			$admin_role->add_cap( PRELAUNCH_MANAGE_TOKENS_CAP );
		}

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			$role->remove_cap( PRELAUNCH_MANAGE_TOKENS_CAP );
		}
	}

	add_action( 'init', 'prelaunch_sync_developer_caps', 25 );
