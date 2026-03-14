<?php
	/**
	 * WordPress user-management access rules for Prelaunch-managed roles.
	 *
	 * Supported policy levels:
	 * - full: keep normal Users access
	 * - profile_only: hide Users, expose only the current user's profile
	 *
	 * This module also cleans up irrelevant profile fields for managed roles.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the Users access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_users_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'users', 'profile_only' );

		if ( ! is_string( $level ) ) {
			return 'profile_only';
		}

		$allowed_levels = array(
			'full',
			'profile_only',
		);

		return in_array( $level, $allowed_levels, true ) ? $level : 'profile_only';
	}

	/**
	 * Get all user-management capabilities controlled by this module.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_users_controlled_caps(): array {
		return array(
			'list_users',
			'create_users',
			'edit_users',
			'delete_users',
			'promote_users',
			'remove_users',
		);
	}

	/**
	 * Sync user-management capabilities for all Prelaunch-managed roles.
	 *
	 * Roles are cloned from Administrator first, so this module removes every
	 * capability it owns before re-applying the correct policy level.
	 *
	 * @return void
	 */
	function prelaunch_sync_managed_role_users_caps(): void {
		$controlled_caps = prelaunch_get_users_controlled_caps();

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			foreach ( $controlled_caps as $cap ) {
				$role->remove_cap( $cap );
			}

			$access_level = prelaunch_get_users_access_level( $role_slug );

			if ( 'full' === $access_level ) {
				foreach ( $controlled_caps as $cap ) {
					$role->add_cap( $cap );
				}
			}
		}
	}

	add_action( 'init', 'prelaunch_sync_managed_role_users_caps', 30 );

	/**
	 * Customize the Users admin menu for managed roles.
	 *
	 * - full: leave Users as-is
	 * - profile_only: remove Users and expose Profile as top-level "My Profile"
	 *
	 * @return void
	 */
	function prelaunch_customize_users_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'users', 'profile_only' );

		if ( 'full' === $access_level ) {
			return;
		}

		remove_menu_page( 'users.php' );

		/**
		 * Rename the default WordPress "Profile" menu item to "My Profile".
		 *
		 * WordPress registers Profile automatically for users who can edit their
		 * own account. Renaming it is cleaner than creating a duplicate entry.
		 */
		global $menu;

		foreach ( $menu as $key => $item ) {
			if ( 'profile.php' === $item[2] ) {
				$menu[ $key ][0] = __( 'My Profile', 'prelaunch-wp' );
				break;
			}
		}
	}

	add_action( 'admin_menu', 'prelaunch_customize_users_admin_menu', 999 );

	/**
	 * Block direct wp-admin access to restricted Users screens.
	 *
	 * This prevents managed roles from manually navigating to user-management
	 * screens by URL when the policy only allows profile access.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_users_admin_screens(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'users', 'profile_only' );

		if ( 'full' === $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) || '' === $pagenow ) {
			return;
		}

		$blocked_pages = array(
			'users.php',
			'user-new.php',
			'user-edit.php',
		);

		if ( in_array( $pagenow, $blocked_pages, true ) ) {
			wp_die(
				esc_html__( 'You do not have access to the Users area on this site.', 'prelaunch-wp' ),
				esc_html__( 'Access denied', 'prelaunch-wp' ),
				array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_users_admin_screens' );

	/**
	 * Disable application passwords for Prelaunch-managed roles.
	 *
	 * These are not part of the intended client workflow for managed roles.
	 *
	 * @param bool $available Whether application passwords are available.
	 * @param WP_User $user User object.
	 *
	 * @return bool
	 */
	function prelaunch_disable_application_passwords_for_managed_roles( bool $available, WP_User $user ): bool {
		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			if ( prelaunch_user_has_role( $user, $role_slug ) ) {
				return false;
			}
		}

		return $available;
	}

	add_filter( 'wp_is_application_passwords_available_for_user', 'prelaunch_disable_application_passwords_for_managed_roles', 10, 2 );

	/**
	 * Remove unused contact methods from managed-role profiles.
	 *
	 * @param array<string, string> $contact_methods Contact methods.
	 *
	 * @return array<string, string>
	 */
	function prelaunch_filter_managed_role_contact_methods( array $contact_methods ): array {
		if ( ! prelaunch_current_user_has_managed_role() ) {
			return $contact_methods;
		}

		unset( $contact_methods['aim'] );
		unset( $contact_methods['yim'] );
		unset( $contact_methods['jabber'] );

		return $contact_methods;
	}

	add_filter( 'user_contactmethods', 'prelaunch_filter_managed_role_contact_methods' );

	/**
	 * Hide unused profile fields for managed roles.
	 *
	 * Hidden fields:
	 * - Website
	 * - Biographical Info
	 * - Application Passwords
	 *
	 * @return void
	 */
	function prelaunch_hide_unused_managed_role_profile_fields(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		global $pagenow;

		if ( ! in_array( $pagenow, array( 'profile.php', 'user-edit.php' ), true ) ) {
			return;
		}
		?>
		<style>
			.user-url-wrap,
			.user-description-wrap,
			.application-passwords,
			.application-passwords-section,
			#application-passwords-section {
				display: none !important;
			}
		</style>
		<?php
	}

	add_action( 'admin_head-profile.php', 'prelaunch_hide_unused_managed_role_profile_fields' );
	add_action( 'admin_head-user-edit.php', 'prelaunch_hide_unused_managed_role_profile_fields' );

	/**
	 * Clear unused profile fields when a managed role saves their profile.
	 *
	 * This prevents clients from entering data into fields that are not part of
	 * the intended workflow, even if those fields become visible for any reason.
	 *
	 * @param int $user_id User ID being updated.
	 *
	 * @return void
	 */
	function prelaunch_clear_unused_managed_role_profile_fields( int $user_id ): void {
		$user = get_userdata( $user_id );

		if ( ! $user instanceof WP_User ) {
			return;
		}

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			if ( prelaunch_user_has_role( $user, $role_slug ) ) {
				wp_update_user(
					array(
						'ID'          => $user_id,
						'user_url'    => '',
						'description' => '',
					)
				);

				return;
			}
		}
	}

	add_action( 'personal_options_update', 'prelaunch_clear_unused_managed_role_profile_fields' );
	add_action( 'edit_user_profile_update', 'prelaunch_clear_unused_managed_role_profile_fields' );
