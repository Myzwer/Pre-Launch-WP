<?php
	/**
	 * ACF Options Page Registration
	 *
	 * Registers client-facing ACF options pages used to manage global
	 * site configuration values (logo, footer data, social links, etc).
	 *
	 * These pages intentionally use the `read` capability rather than
	 * `edit_posts`.
	 *
	 * Why:
	 * The Prelaunch role system can disable post editing by removing
	 * the `edit_posts` capability for certain managed roles when the
	 * Posts feature is turned off. If an options page requires
	 * `edit_posts`, it would disappear for those roles even though
	 * they should still be able to manage site settings.
	 *
	 * Using `read` ensures the options page remains accessible to any
	 * logged-in role while still allowing the role-policy system to
	 * control visibility of the ACF admin UI itself.
	 *
	 * This file should only register options pages intended for
	 * client-facing configuration. Developer-only options pages
	 * (such as Tokens) may use stricter capabilities and/or be
	 * hidden by the role-access modules.
	 *
	 * Hooked into `acf/init` to ensure ACF is loaded before
	 * registering the options page.
	 */

	declare( strict_types=1 );

	/**
	 * Register the ACF "Globals" options page.
	 *
	 * Hooked into `acf/init` to ensure ACF is fully loaded before use.
	 */
	add_action( 'acf/init', static function (): void {
		// Bail early if ACF is not active or available.
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		acf_add_options_page( [
			'page_title' => 'Globals',
			'menu_title' => 'Globals',
			'menu_slug'  => 'acf-globals',
			'capability' => 'read',
			'icon_url'   => 'dashicons-admin-site', // Globe icon
			'redirect'   => false,
		] );
	} );
