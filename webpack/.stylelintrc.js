/**
 * Stylelint configuration.
 *
 * Lints plain CSS for correctness and consistency.
 * Tailwind-specific at-rules are explicitly allowed.
 *
 * @docs https://stylelint.io/user-guide/
 */

module.exports = {
	plugins: [],

	rules: {
		// Prevent false positives on empty or generated files.
		"no-empty-source": null,

		// Basic correctness / consistency rules.
		"no-duplicate-selectors": true,
		"color-hex-length": "long",
		"function-url-quotes": "always",
		"font-family-name-quotes": "always-unless-keyword",
		"comment-whitespace-inside": "always",
		"selector-pseudo-element-colon-notation": "single",

		// Enforce modern, non-prefixed syntax.
		"selector-no-vendor-prefix": true,
		"property-no-vendor-prefix": true,
		"value-no-vendor-prefix": true,
		"media-feature-name-no-vendor-prefix": true,

		// Common modern CSS units allowed.
		"unit-allowed-list": [
			"px",
			"em",
			"rem",
			"deg",
			"%",
			"vh",
			"vw",
			"vmin",
			"vmax",
			"fr",
			"ch",
			"s",
			"ms",
		],

		// Allow Tailwind v4 and related at-rules.
		"at-rule-no-unknown": [
			true,
			{
				ignoreAtRules: ["tailwind", "apply", "layer", "config", "plugin", "theme", "reference"],
			},
		],
	},
};


