<?php
	/**
	 * ACF options page registration.
	 *
	 * Registers Prelaunch ACF options pages used for site-wide configuration.
	 *
	 * Capability rules:
	 * - Client-facing options pages should use `read` so they remain accessible
	 *   even when post editing is disabled by the managed-role system.
	 * - Developer-only options pages should use a dedicated custom capability so
	 *   they stay private even when managed roles retain broader admin access.
	 *
	 * This file is intentionally limited to options-page registration. Access to
	 * the core ACF admin UI (Field Groups, Tools, etc.) is controlled separately
	 * by the user-access modules.
	 */

	declare( strict_types=1 );

	defined( 'ABSPATH' ) || exit;

	/**
	 * Register a Prelaunch ACF options page.
	 *
	 * This helper keeps options-page registration consistent and prevents client-
	 * facing settings pages from accidentally depending on unrelated caps like
	 * edit_posts.
	 *
	 * Supported visibility types:
	 * - client: uses `read`
	 * - developer: uses PRELAUNCH_MANAGE_TOKENS_CAP
	 *
	 * @param array{
	 *     page_title: string,
	 *     menu_title: string,
	 *     menu_slug: string,
	 *     icon_url?: string,
	 *     redirect?: bool,
	 *     visibility?: string
	 * } $args Options page arguments.
	 *
	 * @return void
	 */
	function prelaunch_register_acf_options_page( array $args ): void {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		$visibility = isset( $args['visibility'] ) ? (string) $args['visibility'] : 'client';

		$capability = 'read';

		if ( 'developer' === $visibility ) {
			$capability = PRELAUNCH_MANAGE_TOKENS_CAP;
		}

		unset( $args['visibility'] );

		acf_add_options_page(
			array_merge(
				array(
					'icon_url'   => 'dashicons-admin-generic',
					'redirect'   => false,
					'capability' => $capability,
				),
				$args
			)
		);
	}

	/**
	 * Register Prelaunch ACF options pages.
	 *
	 * Hooked into `acf/init` to ensure ACF is fully loaded before use.
	 *
	 * @return void
	 */
	function prelaunch_register_acf_options_pages(): void {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		prelaunch_register_acf_options_page(
			array(
				'page_title' => 'Globals',
				'menu_title' => 'Globals',
				'menu_slug'  => 'acf-globals',
				'icon_url'   => 'dashicons-admin-site',
				'visibility' => 'client',
			)
		);

		prelaunch_register_acf_options_page(
			array(
				'page_title' => 'Tokens',
				'menu_title' => 'Tokens',
				'menu_slug'  => 'tokens',
				'icon_url'   => 'dashicons-tickets-alt',
				'visibility' => 'developer',
			)
		);
	}

	add_action( 'acf/init', 'prelaunch_register_acf_options_pages' );
