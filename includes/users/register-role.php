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
	 * Posts-only editor role slug.
	 */
	const PRELAUNCH_POSTS_EDITOR_ROLE = 'prelaunch_posts_editor';

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
			PRELAUNCH_POSTS_EDITOR_ROLE,
		);
	}

	/**
	 * Get the human-readable labels for Prelaunch-managed roles.
	 *
	 * @return array<string, string>
	 */
	function prelaunch_get_managed_role_labels(): array {
		return array(
			PRELAUNCH_CLIENT_ADMIN_ROLE => __( 'Site Administrator', 'prelaunch-wp' ),
			PRELAUNCH_POSTS_EDITOR_ROLE => __( 'Posts Editor', 'prelaunch-wp' ),
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
	 * Determine whether the current user is the Prelaunch posts editor role.
	 *
	 * @return bool
	 */
	function prelaunch_is_posts_editor(): bool {
		return prelaunch_user_has_role( wp_get_current_user(), PRELAUNCH_POSTS_EDITOR_ROLE );
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
	 * Each managed role is cloned from the default Administrator role first.
	 * Feature modules then remove or re-apply capabilities based on role policy.
	 *
	 * If a role already exists, any missing Administrator capabilities are added
	 * so the role stays in sync with plugin-added caps before module restrictions
	 * are applied.
	 *
	 * @return void
	 */
	function prelaunch_register_managed_roles(): void {
		$admin_role = get_role( PRELAUNCH_OWNER_ROLE );

		if ( ! $admin_role ) {
			return;
		}

		$role_labels = prelaunch_get_managed_role_labels();

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$managed_role = get_role( $role_slug );

			if ( ! $managed_role ) {
				add_role(
					$role_slug,
					$role_labels[ $role_slug ] ?? $role_slug,
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

	/**
	 * Hard-deny leftover Administrator capabilities on Posts Editor.
	 *
	 * Managed roles are cloned from Administrator, then feature modules strip
	 * only the caps they own. Posts Editor would otherwise keep unfiltered HTML,
	 * unfiltered uploads, manage_options (plugin admin), and core updates.
	 *
	 * Site Administrator keeps those leftovers on purpose: their extra screens
	 * are hidden, not capability-stripped.
	 *
	 * Runs after feature modules (priority 30) so clone + media full cannot
	 * re-grant these on the same request.
	 *
	 * @return void
	 */
	function prelaunch_sync_posts_editor_restricted_caps(): void {
		$role = get_role( PRELAUNCH_POSTS_EDITOR_ROLE );

		if ( ! $role ) {
			return;
		}

		$denied_caps = array(
			'unfiltered_html',
			'unfiltered_upload',
			'manage_options',
			'update_core',
			'edit_files',
		);

		foreach ( $denied_caps as $cap ) {
			$role->remove_cap( $cap );
		}
	}

	add_action( 'init', 'prelaunch_sync_posts_editor_restricted_caps', 40 );
