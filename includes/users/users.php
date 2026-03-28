<?php
	/**
	 * Prelaunch user role loader.
	 *
	 * Loads custom role registration, central role policy, and feature modules.
	 *
	 * To reset a custom role during development:
	 *
	 * 1. Navigate to the WordPress root (where wp-config.php lives).
	 * 2. Delete the custom role slug you want to rebuild.
	 * 3. Run: wp eval 'do_action("init");'
	 *
	 * Example:
	 * wp role delete prelaunch_client_admin
	 * wp eval 'do_action("init");'
	 */

	defined( 'ABSPATH' ) || exit;

	require_once get_theme_file_path( 'includes/users/register-role.php' );
	require_once get_theme_file_path( 'includes/users/role-policy.php' );

	require_once get_theme_file_path( 'includes/users/user-dashboard.php' );
	require_once get_theme_file_path( 'includes/users/user-media.php' );
	require_once get_theme_file_path( 'includes/users/user-pages.php' );
	require_once get_theme_file_path( 'includes/users/gravity-forms.php' );
	require_once get_theme_file_path( 'includes/users/user-posts.php' );
	require_once get_theme_file_path( 'includes/users/user-appearance.php' );
	require_once get_theme_file_path( 'includes/users/user-plugins.php' );
	require_once get_theme_file_path( 'includes/users/user-users.php' );
	require_once get_theme_file_path( 'includes/users/user-tools.php' );
	require_once get_theme_file_path( 'includes/users/user-settings.php' );
	require_once get_theme_file_path( 'includes/users/user-acf.php' );
	require_once get_theme_file_path( 'includes/users/user-plugin-settings.php' );
	require_once get_theme_file_path( 'includes/users/user-admin-bar.php' );
