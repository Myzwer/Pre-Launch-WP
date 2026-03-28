<?php
	/**
	 * WordPress page access rules for Prelaunch-managed roles.
	 *
	 * Supported policy levels:
	 * - full: normal page access
	 * - draft_only: can create and edit pages, but cannot publish them
	 * - off: no page access
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the page access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_pages_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'pages', 'off' );

		if ( ! is_string( $level ) ) {
			return 'off';
		}

		$allowed_levels = array(
			'full',
			'draft_only',
			'off',
		);

		return in_array( $level, $allowed_levels, true ) ? $level : 'off';
	}

	/**
	 * Get the page-related capabilities controlled by this module.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_pages_controlled_caps(): array {
		return array(
			'edit_pages',
			'edit_others_pages',
			'edit_private_pages',
			'edit_published_pages',
			'publish_pages',
			'delete_pages',
			'delete_others_pages',
			'delete_private_pages',
			'delete_published_pages',
			'read_private_pages',
		);
	}

	/**
	 * Sync page capabilities for all Prelaunch-managed roles.
	 *
	 * Roles are cloned from Administrator first, so this module removes every
	 * capability it owns before re-applying the correct policy level.
	 *
	 * @return void
	 */
	function prelaunch_sync_managed_role_pages_caps(): void {
		$controlled_caps = prelaunch_get_pages_controlled_caps();

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			foreach ( $controlled_caps as $cap ) {
				$role->remove_cap( $cap );
			}

			$access_level = prelaunch_get_pages_access_level( $role_slug );

			switch ( $access_level ) {
				case 'full':
					$role->add_cap( 'edit_pages' );
					$role->add_cap( 'edit_others_pages' );
					$role->add_cap( 'edit_private_pages' );
					$role->add_cap( 'edit_published_pages' );
					$role->add_cap( 'publish_pages' );
					$role->add_cap( 'delete_pages' );
					$role->add_cap( 'delete_others_pages' );
					$role->add_cap( 'delete_private_pages' );
					$role->add_cap( 'delete_published_pages' );
					$role->add_cap( 'read_private_pages' );
					break;

				case 'draft_only':
					$role->add_cap( 'edit_pages' );
					$role->add_cap( 'edit_others_pages' );
					$role->add_cap( 'edit_private_pages' );
					$role->add_cap( 'edit_published_pages' );
					$role->add_cap( 'delete_pages' );
					$role->add_cap( 'delete_others_pages' );
					$role->add_cap( 'delete_private_pages' );
					$role->add_cap( 'read_private_pages' );
					/*
					 * Intentionally not granted:
					 * - publish_pages
					 * - delete_published_pages
					 */
					break;

				case 'off':
				default:
					break;
			}
		}
	}

	add_action( 'init', 'prelaunch_sync_managed_role_pages_caps', 31 );

	/**
	 * Clean up the Pages admin menu for managed roles.
	 *
	 * - full: leave Pages as-is
	 * - draft_only: keep Pages access
	 * - off: remove Pages completely
	 *
	 * @return void
	 */
	function prelaunch_customize_pages_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'pages', 'off' );

		if ( 'off' === $access_level ) {
			remove_menu_page( 'edit.php?post_type=page' );
		}
	}

	add_action( 'admin_menu', 'prelaunch_customize_pages_admin_menu', 999 );

	/**
	 * Block direct wp-admin access to restricted Page screens.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_pages_admin_screens(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'pages', 'off' );

		if ( 'off' !== $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) || '' === $pagenow ) {
			return;
		}

		$is_pages_list  = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'page' === sanitize_key( wp_unslash( $_GET['post_type'] ) );
		$is_page_editor = in_array( $pagenow, array(
				'post.php',
				'post-new.php'
			), true ) && prelaunch_is_current_admin_screen_for_pages();

		if ( $is_pages_list || $is_page_editor ) {
			wp_die(
				esc_html__( 'You do not have access to Pages on this site.', 'prelaunch-wp' ),
				esc_html__( 'Access denied', 'prelaunch-wp' ),
				array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_pages_admin_screens' );

	/**
	 * Determine whether the current admin request is for the Page post type.
	 *
	 * @return bool
	 */
	function prelaunch_is_current_admin_screen_for_pages(): bool {
		global $typenow, $pagenow;

		if ( 'page' === $typenow ) {
			return true;
		}

		if ( 'post-new.php' === $pagenow ) {
			$post_type = isset( $_GET['post_type'] ) ? sanitize_key( wp_unslash( $_GET['post_type'] ) ) : 'post';

			return 'page' === $post_type;
		}

		if ( 'post.php' === $pagenow && isset( $_GET['post'] ) ) {
			$post_id = absint( wp_unslash( $_GET['post'] ) );

			return $post_id > 0 && 'page' === get_post_type( $post_id );
		}

		return false;
	}

	/**
	 * Prevent draft_only roles from publishing pages.
	 *
	 * This blocks attempts to publish or schedule a page even if a plugin or UI
	 * still surfaces a publish action somewhere unexpected.
	 *
	 * @param array<string, mixed> $data Sanitized post data.
	 * @param array<string, mixed> $postarr Raw post array.
	 *
	 * @return array<string, mixed>
	 */
	function prelaunch_prevent_page_publishing_for_draft_only( array $data, array $postarr ): array {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return $data;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'pages', 'off' );

		if ( 'draft_only' !== $access_level ) {
			return $data;
		}

		if ( 'page' !== ( $data['post_type'] ?? '' ) ) {
			return $data;
		}

		$requested_status = $data['post_status'] ?? '';

		if ( in_array( $requested_status, array( 'publish', 'future' ), true ) ) {
			$data['post_status'] = 'draft';
		}

		return $data;
	}

	add_filter( 'wp_insert_post_data', 'prelaunch_prevent_page_publishing_for_draft_only', 10, 2 );

	/**
	 * Hide publish-focused UI for draft_only page users.
	 *
	 * This is UX cleanup only. Real enforcement happens in the insert-post filter.
	 *
	 * @return void
	 */
	function prelaunch_hide_restricted_page_publish_ui(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'pages', 'off' );

		if ( 'draft_only' !== $access_level || ! prelaunch_is_current_admin_screen_for_pages() ) {
			return;
		}
		?>
		<style>
			.editor-post-publish-button,
			.editor-post-publish-panel,
			.editor-post-publish-panel__toggle,
			.components-button.editor-post-publish-panel__button,
			#publish,
			.misc-pub-section.misc-pub-post-status .edit-timestamp,
			.misc-pub-section.curtime,
			#minor-publishing-actions .preview.button,
			#major-publishing-actions #publish {
				display: none !important;
			}
		</style>
		<?php
	}

	add_action( 'admin_head-post.php', 'prelaunch_hide_restricted_page_publish_ui' );
	add_action( 'admin_head-post-new.php', 'prelaunch_hide_restricted_page_publish_ui' );
