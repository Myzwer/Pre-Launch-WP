<?php
	/**
	 * Prelaunch user role loader.
	 *
	 * Loads custom role registration and role-specific access modules.
	 *
	 * To reset a custom role during development:
	 *
	 * 1. Navigate to the WordPress root (where wp-config.php lives).
	 * 2. Delete the custom role slug you want to rebuild.
	 * 3. Run: wp eval 'do_action("init");'
	 *
	 * Example (use this for the generic client role):
	 * wp role delete prelaunch_client_admin
	 * wp eval 'do_action("init");'
	 */

	defined( 'ABSPATH' ) || exit;

	require_once get_theme_file_path( 'includes/users/register-role.php' );
	require_once get_theme_file_path( 'includes/users/gravity-forms.php' );
