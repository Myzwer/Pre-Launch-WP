<?php
	/**
	 * WordPress media-library access rules for Prelaunch-managed roles.
	 *
	 * Supported policy levels:
	 * - full: normal media-library access, including uploads
	 * - browse_only: can view/select existing media, but cannot upload new files
	 * - off: no media access
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Get the Media access level for a managed role.
	 *
	 * @param string $role_slug Role slug.
	 *
	 * @return string
	 */
	function prelaunch_get_media_access_level( string $role_slug ): string {
		$level = prelaunch_get_role_policy_value( $role_slug, 'media', 'full' );

		if ( ! is_string( $level ) ) {
			return 'full';
		}

		$allowed_levels = array(
			'full',
			'browse_only',
			'off',
		);

		return in_array( $level, $allowed_levels, true ) ? $level : 'full';
	}

	/**
	 * Get the media-related capabilities controlled by this module.
	 *
	 * upload_files:
	 * Required for normal media-library access.
	 *
	 * unfiltered_upload:
	 * Lets privileged users bypass normal upload restrictions. This should only
	 * remain enabled for the full level.
	 *
	 * @return array<int, string>
	 */
	function prelaunch_get_media_controlled_caps(): array {
		return array(
			'upload_files',
			'unfiltered_upload',
		);
	}

	/**
	 * Sync media capabilities for all Prelaunch-managed roles.
	 *
	 * Roles are cloned from Administrator first, so this module removes every
	 * capability it owns before re-applying the correct policy level.
	 *
	 * browse_only intentionally keeps upload_files so users can still access the
	 * Media Library and select existing assets. Actual upload attempts are blocked
	 * separately at the request layer.
	 *
	 * @return void
	 */
	function prelaunch_sync_managed_role_media_caps(): void {
		$controlled_caps = prelaunch_get_media_controlled_caps();

		foreach ( prelaunch_get_managed_user_roles() as $role_slug ) {
			$role = get_role( $role_slug );

			if ( ! $role ) {
				continue;
			}

			foreach ( $controlled_caps as $cap ) {
				$role->remove_cap( $cap );
			}

			$access_level = prelaunch_get_media_access_level( $role_slug );

			switch ( $access_level ) {
				case 'full':
					$role->add_cap( 'upload_files' );

					// Site Administrator may keep unfiltered uploads. Posts Editor
					// must stay on WordPress mime checks (no SVG/HTML upload XSS).
					if ( PRELAUNCH_CLIENT_ADMIN_ROLE === $role_slug ) {
						$role->add_cap( 'unfiltered_upload' );
					}
					break;

				case 'browse_only':
					$role->add_cap( 'upload_files' );
					break;

				case 'off':
				default:
					break;
			}
		}
	}

	add_action( 'init', 'prelaunch_sync_managed_role_media_caps', 30 );

	/**
	 * Clean up the Media admin menu for managed roles.
	 *
	 * - full: leave Media as-is
	 * - browse_only: keep Media Library, remove Add New
	 * - off: remove Media completely
	 *
	 * @return void
	 */
	function prelaunch_customize_media_admin_menu(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'media', 'full' );

		if ( 'full' === $access_level ) {
			return;
		}

		if ( 'off' === $access_level ) {
			remove_menu_page( 'upload.php' );

			return;
		}

		if ( 'browse_only' === $access_level ) {
			remove_submenu_page( 'upload.php', 'media-new.php' );
		}
	}

	add_action( 'admin_menu', 'prelaunch_customize_media_admin_menu', 999 );

	/**
	 * Block direct wp-admin access to restricted Media screens.
	 *
	 * @return void
	 */
	function prelaunch_maybe_block_media_admin_screens(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'media', 'full' );

		if ( 'full' === $access_level ) {
			return;
		}

		global $pagenow;

		if ( ! is_string( $pagenow ) || '' === $pagenow ) {
			return;
		}

		if ( 'off' === $access_level ) {
			$blocked_pages = array(
				'upload.php',
				'media-new.php',
				'media.php',
				'async-upload.php',
			);

			if ( in_array( $pagenow, $blocked_pages, true ) ) {
				wp_die(
					esc_html__( 'You do not have access to the Media area on this site.', 'prelaunch-wp' ),
					esc_html__( 'Access denied', 'prelaunch-wp' ),
					array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}

			return;
		}

		if ( 'browse_only' === $access_level && 'media-new.php' === $pagenow ) {
			wp_die(
				esc_html__( 'You can browse existing media on this site, but you cannot upload new files.', 'prelaunch-wp' ),
				esc_html__( 'Upload disabled', 'prelaunch-wp' ),
				array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	add_action( 'admin_init', 'prelaunch_maybe_block_media_admin_screens' );

	/**
	 * Reject media uploads for managed roles when uploads are disabled.
	 *
	 * This is the server-side enforcement for browse_only and off. It catches
	 * uploads even if a button, modal, or plugin UI still manages to expose one.
	 *
	 * @param array<string, mixed> $file Upload file array.
	 *
	 * @return array<string, mixed>
	 */
	function prelaunch_maybe_block_managed_role_media_uploads( array $file ): array {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return $file;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'media', 'full' );

		if ( 'full' === $access_level ) {
			return $file;
		}

		$file['error'] = esc_html__(
			'You do not have permission to upload new media files on this site.',
			'prelaunch-wp'
		);

		return $file;
	}

	add_filter( 'wp_handle_upload_prefilter', 'prelaunch_maybe_block_managed_role_media_uploads' );

	/**
	 * Hide upload-focused UI for managed roles when uploads are disabled.
	 *
	 * This is UX cleanup only. Real enforcement happens through the blocked
	 * screen checks and upload prefilter above.
	 *
	 * @return void
	 */
	function prelaunch_hide_restricted_media_upload_ui(): void {
		if ( ! is_admin() || ! prelaunch_current_user_has_managed_role() ) {
			return;
		}

		$access_level = prelaunch_get_current_role_policy_value( 'media', 'full' );

		if ( 'browse_only' !== $access_level && 'off' !== $access_level ) {
			return;
		}
		?>
		<style>
			.page-title-action,
			.upload-ui,
			.media-frame .uploader-inline,
			.media-frame .attachments-browser .media-toolbar-primary .media-button,
			.media-frame .attachments-browser .browser .button[href*="media-new.php"] {
				display: none !important;
			}
		</style>
		<?php
	}

	add_action( 'admin_head-upload.php', 'prelaunch_hide_restricted_media_upload_ui' );
	add_action( 'admin_head-media-new.php', 'prelaunch_hide_restricted_media_upload_ui' );
	add_action( 'admin_head-post.php', 'prelaunch_hide_restricted_media_upload_ui' );
	add_action( 'admin_head-post-new.php', 'prelaunch_hide_restricted_media_upload_ui' );
