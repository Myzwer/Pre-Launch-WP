<?php
	/**
	 * WordPress post-editor access rules for Prelaunch-managed roles.
	 *
	 * This module controls access to the built-in "Posts" content system.
	 * It is intentionally binary for now:
	 *
	 * - true: role keeps normal post access
	 * - false: role cannot access Posts in admin
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Determine whether a managed role should have access to Posts.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return bool
	 */
	function prelaunch_role_has_posts_access( string $role_slug ): bool {
		return prelaunch_role_has_feature_access( $role_slug, 'posts' );
	}

	/**
	 * Get the post-related capabilities controlled by this module.
	 *
	 * These map to the built-in "post" post type and related taxonomy terms.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_posts_module_caps(): array {
		return array(
			'edit_posts',
			'edit_others_posts',
			'edit_published_posts',
			'edit_private_posts',
			'publish_posts',
			'delete_posts',
			'delete_others_posts',
			'delete_published_posts',
			'delete_private_posts',
			'read_private_posts',
			'manage_categories',
		);
	}

	/**
	 * Sync post capabilities for all Prelaunch-managed roles.
	 *
	 * Because managed roles are cloned from Administrator, this module removes
	 * or restores Posts access per role based on the central policy layer.
	 *
	 * @return void
	 */
	function prelaunch_sync_managed_role_posts_caps(): void {
		$post_caps = prelaunch_get_posts_module_caps();

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			if ( prelaunch_role_has_posts_access( $role_slug ) ) {
				foreach ( $post_caps as $cap ) {
					$role->add_cap( $cap );
				}

				continue;
			}

			foreach ( $post_caps as $cap ) {
				$role->remove_cap( $cap );
			}
		}
	}

	add_action( 'init', 'prelaunch_sync_managed_role_posts_caps', 30 );

	/**
	 * Remove the Posts admin menu for managed users when Posts are disabled.
	 *
	 * This is admin UX cleanup only. Capability enforcement is handled separately.
	 *
	 * @return void
	 */
	function prelaunch_maybe_hide_posts_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		if ( prelaunch_current_user_has_feature_access( 'posts' ) ) {
			return;
		}

		remove_menu_page( 'edit.php' );
	}

	add_action( 'admin_menu', 'prelaunch_maybe_hide_posts_admin_menu', 999 );

	/**
	 * Block direct wp-admin access to the Posts area for managed users when disabled.
	 *
	 * This prevents manually navigating to post-management screens by URL.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_posts_admin_screens(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		if ( prelaunch_current_user_has_feature_access( 'posts' ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( ! $screen ) {
			return;
		}

		$post_screens = array(
			'edit-post',
			'post',
		);

		$post_taxonomy_screens = array(
			'edit-category',
			'edit-post_tag',
		);

		if (
			in_array( $screen->id, $post_screens, true ) ||
			in_array( $screen->id, $post_taxonomy_screens, true )
		) {
			wp_die(
				esc_html__( 'You do not have access to the Posts area on this site.', 'prelaunch-wp' ),
				esc_html__( 'Access denied', 'prelaunch-wp' ),
				array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	add_action( 'current_screen', 'prelaunch_maybe_block_posts_admin_screens' );
