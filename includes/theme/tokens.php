<?php
	/**
	 * Shared PHP design tokens for WordPress-driven UI contexts.
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Return brand color tokens used by PHP-driven theme contexts.
	 *
	 * @return array<string, string>
	 */
	function prelaunch_get_brand_colors(): array {
		return [
			// Neutrals.
			'black'                 => '#0F172A',
			'white'                 => '#F8FAFC',

			// Brand roles.
			'primary'               => '#63C1E9',
			'secondary'             => '#397B52',
			'soft-1'                => '#E0F2FE',
			'soft-2'                => '#ECFDF3',

			// Gradient endpoints.
			'primary-gradient-to'   => '#C9E9FF',
			'secondary-gradient-to' => '#C6FFDD',
			'impact-gradient-to'    => '#28563A',
		];
	}
