<?php
	/**
	 * Prelaunch custom role registration.
	 *
	 * Registers and syncs all Prelaunch-managed roles.
	 *
	 * Roles are cloned from the core Administrator role first, then restricted
	 * by feature modules. This keeps the system modular and self-healing.
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
	 * Get the Prelaunch-managed role configuration map.
	 *
	 * This is the source of truth for which custom roles should be registered.
	 * Add future roles here when they are ready to be created.
	 *
	 * @return array<string, string>
	 */
	function prelaunch_get_managed_role_config(): array {
		return array(
			PRELAUNCH_CLIENT_ADMIN_ROLE => __( 'Site Administrator', 'prelaunch-wp' ),
		);
	}

	/**
	 * Get all Prelaunch-managed role slugs.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_managed_user_roles(): array {
		return array_keys( prelaunch_get_managed_role_config() );
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
	 * Register or sync all Prelaunch-managed roles.
	 *
	 * Each managed role is cloned from the default Administrator role. If the
	 * role already exists, missing Administrator capabilities are added back so
	 * the feature modules can deterministically remove or re-add only what they
	 * control.
	 *
	 * @return void
	 */
	function prelaunch_register_managed_roles(): void {
		$admin_role = get_role( PRELAUNCH_OWNER_ROLE );

		if ( ! $admin_role ) {
			return;
		}

		foreach ( prelaunch_get_managed_role_config() as $role_slug => $role_label ) {
			$managed_role = get_role( $role_slug );

			if ( ! $managed_role ) {
				add_role(
					$role_slug,
					$role_label,
					$admin_role->capabilities
				);

				$managed_role = get_role( $role_slug );
			}

			if ( ! $managed_role ) {
				continue;
			}

			foreach ( $admin_role->capabilities as $cap => $grant ) {
				if ( $grant ) {
					$managed_role->add_cap( $cap );
				}
			}
		}
	}

	add_action( 'init', 'prelaunch_register_managed_roles', 20 );
