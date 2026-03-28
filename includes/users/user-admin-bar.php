<?php
	/**
	 * Admin bar cleanup for Prelaunch-managed roles.
	 *
	 * Removes misleading or workflow-breaking toolbar shortcuts for managed roles
	 * so the admin UI reflects the intended experience.
	 *
	 * Current behavior:
	 * - Posts: shown only when the role has posts access.
	 * - Pages: shown only when the role has pages access.
	 * - Gravity Forms: shown only when the role has Gravity Forms access.
	 * - Media: always hidden for managed roles.
	 *
	 * Media is intentionally hidden regardless of policy because the default
	 * "+ New > Media" shortcut bypasses the preferred FileBird workflow and
	 * makes it easier to upload into the wrong location.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Remove disallowed admin-bar shortcuts for managed roles.
	 *
	 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
	 *
	 * @return void
	 */
	function prelaunch_customize_admin_bar( WP_Admin_Bar $wp_admin_bar ): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		/*
		 * Posts are binary in the current policy system.
		 */
		if ( ! prelaunch_current_user_has_feature_access( 'posts' ) ) {
			$wp_admin_bar->remove_node( 'new-post' );
		}

		/*
		 * Pages are available for both full and draft_only access levels.
		 */
		if ( ! prelaunch_current_user_has_feature_access( 'pages' ) ) {
			$wp_admin_bar->remove_node( 'new-page' );
		}

		/*
		 * Gravity Forms uses the shared feature-access helper.
		 */
		if ( ! prelaunch_current_user_has_feature_access( 'gravity_forms' ) ) {
			$wp_admin_bar->remove_node( 'gravityforms-new-form' );
		}

		/*
		 * README:ADMIN_BAR_MEDIA_ALWAYS_HIDDEN
		 * Hide "+ New > Media" for all managed roles regardless of media policy.
		 *
		 * Reason:
		 * The default shortcut does not play nicely with the FileBird workflow and
		 * makes it easier to upload files outside the intended folder structure.
		 */
		$wp_admin_bar->remove_node( 'new-media' );

		/*
		 * Remove the parent "+ New" menu if nothing meaningful remains.
		 */
		$remaining_children = array(
			$wp_admin_bar->get_node( 'new-post' ),
			$wp_admin_bar->get_node( 'new-page' ),
			$wp_admin_bar->get_node( 'gravityforms-new-form' ),
			$wp_admin_bar->get_node( 'user-new' ),
		);

		$has_remaining_children = false;

		foreach ( $remaining_children as $child_node ) {
			if ( $child_node ) {
				$has_remaining_children = true;
				break;
			}
		}

		if ( ! $has_remaining_children ) {
			$wp_admin_bar->remove_node( 'new-content' );
		}
	}

	add_action( 'admin_bar_menu', 'prelaunch_customize_admin_bar', 999 );
