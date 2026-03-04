<?php

	/**
	 * Shortcodes
	 *
	 * Starter-theme shortcodes intended for ACF/WYSIWYG usage.
	 *
	 * - [btn]    Tailwind-styled button link with optional Font Awesome icon.
	 * - [social] Social icon link (URL from shortcode override or ACF Options "Globals").
	 *
	 * Notes:
	 * - Output is wrapped in `not-prose` to avoid Tailwind Typography (.prose) styling conflicts.
	 * - Social URLs default to ACF option fields (Globals) if a URL isn't passed.
	 * - Missing required values return an empty string (no broken placeholders).
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_shortcode/
	 * @link https://developer.wordpress.org/reference/functions/shortcode_atts/
	 */

	declare( strict_types=1 );

	/**
	 * Internal: Normalize a Y/N-style flag.
	 */
	function windpeak_shortcode_flag( string $value, bool $default = false ): bool {
		$value = strtoupper( trim( $value ) );

		if ( in_array( $value, [ 'Y', 'YES', 'TRUE', '1' ], true ) ) {
			return true;
		}

		if ( in_array( $value, [ 'N', 'NO', 'FALSE', '0' ], true ) ) {
			return false;
		}

		return $default;
	}

	/**
	 * Internal: Normalize and sanitize a tel: number.
	 */
	function windpeak_normalize_phone_for_tel( string $phone ): string {
		$phone = trim( $phone );

		// Keep digits and a single leading + (international).
		$phone = preg_replace( '/(?!^\+)[^\d]/', '', $phone ) ?? '';
		$phone = preg_replace( '/^\+?(\d.*)$/', '+$1', $phone ) ?? $phone;

		return ( strlen( $phone ) >= 8 ) ? $phone : '';
	}

	/**
	 * Internal: Safe access to ACF option fields (Globals).
	 */
	function windpeak_get_acf_option( string $field_name ): string {
		if ( ! function_exists( 'get_field' ) ) {
			return '';
		}

		$value = get_field( $field_name, 'option' );

		return is_string( $value ) ? trim( $value ) : '';
	}

	/**
	 * Internal: Resolve a social network URL from shortcode override or ACF options.
	 */
	function windpeak_resolve_social_href( string $network, string $override_url = '' ): string {
		$network      = strtolower( trim( $network ) );
		$override_url = trim( $override_url );

		// Explicit override always wins.
		if ( $override_url !== '' ) {
			if ( $network === 'email' ) {
				$email = sanitize_email( $override_url );

				return $email ? 'mailto:' . $email : '';
			}

			if ( $network === 'phone' ) {
				$phone = windpeak_normalize_phone_for_tel( $override_url );

				return $phone ? 'tel:' . $phone : '';
			}

			return esc_url( $override_url );
		}

		// ACF Options (Globals) field naming convention.
		$map = [
			'facebook'  => 'facebook_url',
			'instagram' => 'instagram_url',
			'x'         => 'x_url',
			'youtube'   => 'youtube_url',
			'pinterest' => 'pinterest_url',
			'linkedin'  => 'linkedin_url',
			'tiktok'    => 'tiktok_url',
			'threads'   => 'threads_url',
			'github'    => 'github_url',
			'website'   => 'website_url',
			'email'     => 'email_address',
			'phone'     => 'phone_number',
		];

		if ( ! isset( $map[ $network ] ) ) {
			return '';
		}

		$value = windpeak_get_acf_option( $map[ $network ] );
		if ( $value === '' ) {
			return '';
		}

		if ( $network === 'email' ) {
			$email = sanitize_email( $value );

			return $email ? 'mailto:' . $email : '';
		}

		if ( $network === 'phone' ) {
			$phone = windpeak_normalize_phone_for_tel( $value );

			return $phone ? 'tel:' . $phone : '';
		}

		return esc_url( $value );
	}

	/**
	 * [btn] shortcode
	 *
	 * Attributes:
	 * - text (required)
	 * - url  (required)
	 * - variant: main|secondary|light|dark|ghost_white|ghost_black (default: main)
	 * - tab: Y|N (default: N)
	 * - center: Y|N (default: N)
	 * - icon: none|arrow|external|download|phone|email (default: none)
	 * - icon_pos: left|right (default: right)
	 */
	function windpeak_shortcode_btn( array $atts ): string {
		$atts = shortcode_atts(
			[
				'text'     => '',
				'url'      => '',
				'variant'  => 'main',
				'tab'      => 'N',
				'center'   => 'N',
				'icon'     => 'none', // default: no icon
				'icon_pos' => 'right',
			],
			$atts,
			'btn'
		);

		$text = trim( (string) $atts['text'] );
		$url  = trim( (string) $atts['url'] );

		if ( $text === '' || $url === '' ) {
			return '';
		}

		$variant     = strtolower( trim( (string) $atts['variant'] ) );
		$variant_map = [
			'main'        => 'btn_main',
			'secondary'   => 'btn_secondary',
			'light'       => 'btn_light',
			'dark'        => 'btn_dark',
			'ghost_white' => 'btn_ghost_white',
			'ghost_black' => 'btn_ghost_black',
		];
		$btn_class   = $variant_map[ $variant ] ?? $variant_map['main'];

		$new_tab = windpeak_shortcode_flag( (string) $atts['tab'], false );
		$center  = windpeak_shortcode_flag( (string) $atts['center'], false );

		$icon     = strtolower( trim( (string) $atts['icon'] ) );
		$icon_pos = strtolower( trim( (string) $atts['icon_pos'] ) ) === 'left' ? 'left' : 'right';

		$icon_map   = [
			'none'     => '',
			'arrow'    => 'fa-solid fa-arrow-right',
			'external' => 'fa-solid fa-arrow-up-right-from-square',
			'download' => 'fa-solid fa-download',
			'phone'    => 'fa-solid fa-phone',
			'email'    => 'fa-solid fa-envelope',
		];
		$icon_class = $icon_map[ $icon ] ?? '';

		$href   = esc_url( $url );
		$target = $new_tab ? ' target="_blank"' : '';
		$rel    = $new_tab ? ' rel="noopener noreferrer"' : '';

		// IMPORTANT: buttons are often placed inside `.prose` content; wrap in not-prose.
		// Also keep the button itself as the <a> so Tailwind button classes apply cleanly.
		$label_html = '<span>' . esc_html( $text ) . '</span>';

		$icon_html = '';
		if ( $icon_class !== '' ) {
			// No manual margins: your Tailwind button classes already use flex + gap-*.
			$icon_html = '<i class="' . esc_attr( $icon_class ) . '" aria-hidden="true"></i>';
		}

		if ( $icon_html !== '' && $icon_pos === 'left' ) {
			$inner = $icon_html . $label_html;
		} elseif ( $icon_html !== '' ) {
			$inner = $label_html . $icon_html;
		} else {
			$inner = $label_html;
		}

		$button = '<a class="' . esc_attr( $btn_class ) . '" href="' . $href . '"' . $target . $rel . '>' . $inner . '</a>';

		if ( $center ) {
			return '<div class="flex justify-center not-prose">' . $button . '</div>';
		}

		return '<span class="inline-block not-prose">' . $button . '</span>';
	}

	add_shortcode( 'btn', 'windpeak_shortcode_btn' );

	/**
	 * Internal: Ordered list of supported social networks for loops.
	 *
	 * - Update this ONE list to control:
	 *   - Which networks exist
	 *   - The output order everywhere you loop socials
	 */
	function windpeak_social_networks_ordered(): array {
		return [
			'facebook',
			'instagram',
			'x',
			'youtube',
			'pinterest',
			'linkedin',
			'tiktok',
			'threads',
			'github',
			'website',
			'email',
			'phone',
		];
	}

	/**
	 * Public: Return a list of social items that actually have URLs.
	 *
	 * Use this in templates so you don't have to maintain arrays in multiple places.
	 *
	 * @param array{
	 *   networks?: string[],  // optional whitelist + ordering override
	 *   overrides?: array<string, string>, // per-network URL override, e.g. ['instagram' => 'https://...']
	 * } $args
	 *
	 * @return array<int, array{
	 *   network: string,
	 *   href: string
	 * }>
	 */
	function windpeak_get_social_items( array $args = [] ): array {
		$networks = $args['networks'] ?? windpeak_social_networks_ordered();
		if ( ! is_array( $networks ) || $networks === [] ) {
			$networks = windpeak_social_networks_ordered();
		}

		$overrides = $args['overrides'] ?? [];
		if ( ! is_array( $overrides ) ) {
			$overrides = [];
		}

		$items = [];

		foreach ( $networks as $network ) {
			$network = strtolower( trim( (string) $network ) );
			if ( $network === '' ) {
				continue;
			}

			$override_url = '';
			if ( isset( $overrides[ $network ] ) && is_string( $overrides[ $network ] ) ) {
				$override_url = $overrides[ $network ];
			}

			$href = windpeak_resolve_social_href( $network, $override_url );
			if ( $href === '' ) {
				continue;
			}

			$items[] = [
				'network' => $network,
				'href'    => $href,
			];
		}

		return $items;
	}

	/**
	 * Public: Render a single social icon (same output rules as the [social] shortcode),
	 * but callable from PHP templates.
	 *
	 * @param string $network
	 * @param array{
	 *   url?: string,
	 *   size?: 'sm'|'md'|'lg'|'xl'|'2xl',
	 *   tab?: 'Y'|'N'|string,
	 *   label?: string,
	 *   shape?: 'none'|'circle'|'square',
	 *   fg?: 'black'|'white'|string,
	 *   color?: 'current'|'primary'|'black'|'white'|string,
	 * } $args
	 *
	 * @return string
	 */
	function windpeak_render_social_icon( string $network, array $args = [] ): string {
		// Reuse the shortcode renderer to guarantee consistent markup + classes.
		// (shortcode_atts will ignore unknown keys.)
		$atts = array_merge(
			[
				'network' => $network,
			],
			$args
		);

		return windpeak_shortcode_social( $atts );
	}

	/**
	 * [social] shortcode
	 *
	 * Attributes:
	 * - network (required): facebook|instagram|x|youtube|pinterest|linkedin|tiktok|threads|github|website|email|phone
	 * - url (optional): override the ACF option field
	 * - size: sm|md|lg|xl|2xl (default: md)  -> mapped larger for icons
	 * - tab: Y|N (default: Y)
	 * - label (optional): aria-label override
	 * - shape: none|circle|square (default: none)
	 * - bg: primary|black|white (default: primary)  (used only when shape != none)
	 * - color: current|primary|black|white (default: current) (used only when shape == none)
	 */
	function windpeak_shortcode_social( array $atts ): string {
		$atts = shortcode_atts(
			[
				'network' => '',
				'url'     => '',
				'size'    => 'md',
				'tab'     => 'Y',
				'label'   => '',
				'shape'   => 'none',
				'fg'      => 'black',   // used only when shape != none
				'color'   => 'current', // used only when shape == none
			],
			$atts,
			'social'
		);

		$network = strtolower( trim( (string) $atts['network'] ) );
		if ( $network === '' ) {
			return '';
		}

		$href = windpeak_resolve_social_href( $network, (string) $atts['url'] );
		if ( $href === '' ) {
			return '';
		}

		// Font Awesome icon mapping.
		$icon_map = [
			'facebook'  => 'fa-brands fa-facebook',
			'instagram' => 'fa-brands fa-instagram',
			'x'         => 'fa-brands fa-x-twitter',
			'youtube'   => 'fa-brands fa-youtube',
			'pinterest' => 'fa-brands fa-pinterest',
			'linkedin'  => 'fa-brands fa-linkedin',
			'tiktok'    => 'fa-brands fa-tiktok',
			'threads'   => 'fa-brands fa-threads',
			'github'    => 'fa-brands fa-github',
			'website'   => 'fa-solid fa-globe',
			'email'     => 'fa-solid fa-envelope',
			'phone'     => 'fa-solid fa-phone',
		];

		$icon_class = $icon_map[ $network ] ?? '';
		if ( $icon_class === '' ) {
			return '';
		}

		// Size mapping bumped up for icon usability.
		$size            = strtolower( trim( (string) $atts['size'] ) );
		$size_map        = [
			'sm'  => 'text-2xl',
			'md'  => 'text-3xl',
			'lg'  => 'text-4xl',
			'xl'  => 'text-5xl',
			'2xl' => 'text-6xl',
		];
		$icon_size_class = $size_map[ $size ] ?? $size_map['md'];

		// Container sizes when using a background shape.
		$box_map        = [
			'sm'  => 'w-10 h-10',
			'md'  => 'w-12 h-12',
			'lg'  => 'w-14 h-14',
			'xl'  => 'w-16 h-16',
			'2xl' => 'w-20 h-20',
		];
		$box_size_class = $box_map[ $size ] ?? $box_map['md'];

		$new_tab = windpeak_shortcode_flag( (string) $atts['tab'], true );
		$target  = $new_tab ? ' target="_blank"' : '';
		$rel     = $new_tab ? ' rel="noopener noreferrer"' : '';

		$label = trim( (string) $atts['label'] );
		if ( $label === '' ) {
			$label = ( $network === 'x' ) ? 'X' : ucfirst( $network );
		}
		$aria = ' aria-label="' . esc_attr( $label ) . '"';

		$shape = strtolower( trim( (string) $atts['shape'] ) );
		if ( ! in_array( $shape, [ 'none', 'circle', 'square' ], true ) ) {
			$shape = 'none';
		}

		// Foreground/background behavior:
		// - If shape == none: use color mapping (current|primary|black|white)
		// - If shape != none: use bg mapping (primary|black|white) and forced contrasting text
		$classes = [];

		if ( $shape === 'none' ) {
			$color     = strtolower( trim( (string) $atts['color'] ) );
			$color_map = [
				'current' => 'text-current',
				'primary' => 'text-primary',
				'black'   => 'text-black',
				'white'   => 'text-white',
			];
			$classes[] = $color_map[ $color ] ?? $color_map['current'];
			$classes[] = $icon_size_class;
		} else {
			// Background is always primary when using a shape.
			$bg_class = 'bg-primary';

			// Foreground (icon) color is configurable, but only black/white to keep it simple.
			$fg       = strtolower( trim( (string) $atts['fg'] ) );
			$fg_class = ( $fg === 'white' ) ? 'text-white' : 'text-black';

			$classes[] = 'inline-flex items-center justify-center';
			$classes[] = $box_size_class;
			$classes[] = $bg_class;
			$classes[] = $fg_class;

			// Shape styling (circle needs a bit more breathing room than square).
			if ( $shape === 'circle' ) {
				$classes[] = 'rounded-full';
				$classes[] = 'p-1'; // gives the icon a touch more space
			} else {
				$classes[] = 'rounded-md';
			}

			// Small interaction polish (no extra choices needed)
			$classes[] = 'transition';
			$classes[] = 'hover:brightness-95';

			$classes[] = $icon_size_class;
		}

		// IMPORTANT: social links are often inside `.prose`; wrap in not-prose to avoid link colors.
		$class_attr = esc_attr( implode( ' ', array_filter( $classes ) ) );

		return '<span class="inline-block not-prose"><a class="' . $class_attr . '" href="' . esc_url( $href ) . '"' . $target . $rel . $aria . '><i class="' . esc_attr( $icon_class ) . '" aria-hidden="true"></i></a></span>';
	}

	add_shortcode( 'social', 'windpeak_shortcode_social' );
