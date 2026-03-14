<?php
	/**
	 * Prelaunch role policy definitions.
	 *
	 * This file is the central policy layer for Prelaunch-managed roles.
	 *
	 * Role registration answers:
	 * - what roles exist?
	 *
	 * Role policy answers:
	 * - what features does each role get?
	 * - what access level does each role have?
	 *
	 * Feature modules should read from this file instead of hardcoding
	 * role-specific business rules inline.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the Prelaunch feature policy map by role.
	 *
	 * Keep this intentionally simple. Binary features can use booleans.
	 * More nuanced features can use string access levels.
	 *
	 * Current supported values:
	 * - posts: true|false
	 * - gravity_forms: off|manager|full
	 * - appearance: off|menus_only|full
	 * - plugins: off|manage_installed|full
	 * - users: profile_only|full
	 *
	 * @return array<string, array<string, mixed>>
	 */
	function prelaunch_get_role_policy(): array {
		return array(
			PRELAUNCH_CLIENT_ADMIN_ROLE => array(
				'posts'         => false,
				'gravity_forms' => 'manager',
				'appearance'    => 'menus_only',
				'plugins'       => 'off',
				'users'         => 'profile_only',
			),
		);
	}

	/**
	 * Get a feature policy value for a specific role.
	 *
	 * @param string $role_slug Role slug.
	 * @param string $feature_key Feature/policy key.
	 * @param mixed $default Default value if not defined.
	 *
	 * @return mixed
	 */
	function prelaunch_get_role_policy_value( string $role_slug, string $feature_key, $default = null ) {
		$policy = prelaunch_get_role_policy();

		if ( ! isset( $policy[ $role_slug ] ) ) {
			return $default;
		}

		if ( ! array_key_exists( $feature_key, $policy[ $role_slug ] ) ) {
			return $default;
		}

		return $policy[ $role_slug ][ $feature_key ];
	}

	/**
	 * Determine whether a role has access to a feature.
	 *
	 * This helper supports both:
	 * - binary booleans (true/false)
	 * - string levels where "off" means disabled
	 *
	 * @param string $role_slug Role slug.
	 * @param string $feature_key Feature/policy key.
	 *
	 * @return bool
	 */
	function prelaunch_role_has_feature_access( string $role_slug, string $feature_key ): bool {
		$value = prelaunch_get_role_policy_value( $role_slug, $feature_key, false );

		return ! in_array( $value, array( false, null, 'off' ), true );
	}

	/**
	 * Get the current user's first matching Prelaunch-managed role slug.
	 *
	 * Managed users should only have one Prelaunch role assigned at a time.
	 *
	 * @return string|null
	 */
	function prelaunch_get_current_managed_role(): ?string {
		$user = wp_get_current_user();

		if ( ! $user instanceof WP_User ) {
			return null;
		}

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			if ( prelaunch_user_has_role( $user, $role_slug ) ) {
				return $role_slug;
			}
		}

		return null;
	}

	/**
	 * Get a policy value for the current user's managed role.
	 *
	 * @param string $feature_key Feature/policy key.
	 * @param mixed $default Default value if not defined.
	 *
	 * @return mixed
	 */
	function prelaunch_get_current_role_policy_value( string $feature_key, $default = null ) {
		$current_role = prelaunch_get_current_managed_role();

		if ( ! $current_role ) {
			return $default;
		}

		return prelaunch_get_role_policy_value( $current_role, $feature_key, $default );
	}

	/**
	 * Determine whether the current managed user has access to a feature.
	 *
	 * @param string $feature_key Feature/policy key.
	 *
	 * @return bool
	 */
	function prelaunch_current_user_has_feature_access( string $feature_key ): bool {
		$current_role = prelaunch_get_current_managed_role();

		if ( ! $current_role ) {
			return false;
		}

		return prelaunch_role_has_feature_access( $current_role, $feature_key );
	}
