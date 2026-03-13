<?php
	/**
	 * Gravity Forms access rules for Prelaunch-managed roles.
	 *
	 * @docs https://docs.gravityforms.com/role-management-guide/
	 *
	 * Policy levels currently supported by this module:
	 * - off
	 * - manager
	 * - full
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the Gravity Forms policy level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_gravity_forms_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'gravity_forms', 'off' );

		return is_string( $level ) ? $level : 'off';
	}

	/**
	 * Get the broad Gravity Forms admin capabilities controlled by this module.
	 *
	 * These are removed for limited roles to prevent access to settings,
	 * add-ons, system status, logging, and other developer-level controls.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_gravity_forms_restricted_caps(): array {
		return array(
			'gform_full_access',
			'gravityforms_view_settings',
			'gravityforms_edit_settings',
			'gravityforms_view_updates',
			'gravityforms_view_addons',
			'gravityforms_system_status',
			'gravityforms_uninstall',
			'gravityforms_logging',
			'gravityforms_api_settings',
		);
	}

	/**
	 * Get the standard form-management capabilities allowed for manager access.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_gravity_forms_manager_caps(): array {
		return array(
			'gravityforms_create_form',
			'gravityforms_delete_forms',
			'gravityforms_edit_forms',
			'gravityforms_preview_forms',
			'gravityforms_view_entries',
			'gravityforms_edit_entries',
			'gravityforms_delete_entries',
			'gravityforms_view_entry_notes',
			'gravityforms_edit_entry_notes',
			'gravityforms_export_entries',
		);
	}

	/**
	 * Sync Gravity Forms capabilities for all Prelaunch-managed roles.
	 *
	 * Roles are cloned from Administrator first, so this module removes every
	 * Gravity Forms capability it owns before re-applying the correct policy
	 * level for each managed role.
	 *
	 * @return void
	 */
	function prelaunch_sync_managed_role_gravity_forms_caps(): void {
		$controlled_caps = array_unique(
			array_merge(
				prelaunch_get_gravity_forms_restricted_caps(),
				prelaunch_get_gravity_forms_manager_caps()
			)
		);

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			foreach ( $controlled_caps as $cap ) {
				$role->remove_cap( $cap );
			}

			$access_level = prelaunch_get_gravity_forms_access_level( $role_slug );

			switch ( $access_level ) {
				case 'full':
					foreach ( $controlled_caps as $cap ) {
						$role->add_cap( $cap );
					}
					break;

				case 'manager':
					foreach ( prelaunch_get_gravity_forms_manager_caps() as $cap ) {
						$role->add_cap( $cap );
					}
					break;

				case 'off':
				default:
					break;
			}
		}
	}

	add_action( 'init', 'prelaunch_sync_managed_role_gravity_forms_caps', 30 );
