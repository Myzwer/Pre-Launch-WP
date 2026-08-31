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

	/**
	 * Populate the flex Form block select with Gravity Forms.
	 *
	 * @param array<string, mixed> $field ACF field array.
	 *
	 * @return array<string, mixed>
	 */
	function prelaunch_acf_load_gravity_form_choices( array $field ): array {
		$field['choices'] = array();

		if ( ! class_exists( 'GFAPI' ) ) {
			return $field;
		}

		$forms = GFAPI::get_forms();

		if ( ! is_array( $forms ) ) {
			return $field;
		}

		usort(
			$forms,
			static function ( $a, $b ): int {
				$a_title = is_array( $a ) ? (string) ( $a['title'] ?? '' ) : '';
				$b_title = is_array( $b ) ? (string) ( $b['title'] ?? '' ) : '';

				return strcasecmp( $a_title, $b_title );
			}
		);

		foreach ( $forms as $form ) {
			if ( ! is_array( $form ) || empty( $form['id'] ) ) {
				continue;
			}

			$id    = (string) (int) $form['id'];
			$title = isset( $form['title'] ) ? (string) $form['title'] : 'Form ' . $id;
			$field['choices'][ $id ] = $title . ' (ID ' . $id . ')';
		}

		return $field;
	}

	add_filter( 'acf/load_field/name=form_id', 'prelaunch_acf_load_gravity_form_choices' );
