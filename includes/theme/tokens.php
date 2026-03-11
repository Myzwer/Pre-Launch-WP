<?php
	/**
	 * Shared PHP design tokens for WordPress-driven UI contexts.
	 */

	defined( 'ABSPATH' ) || exit;

	function prelaunch_get_brand_colors(): array {
		return [
			'black'     => '#0F172A',
			'white'     => '#F8FAFC',
			'primary'   => '#63C1E9',
			'secondary' => '#397B52',
			'soft-1'    => '#E0F2FE',
			'soft-2'    => '#ECFDF3',
		];
	}
