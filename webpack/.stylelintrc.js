/**
 * Stylelint config file
 * as configured in package.json under stylelint.extends
 *
 * @docs Stylelint https://stylelint.io/user-guide/
 * @docs StylelintWebpackPlugin: https://webpack.js.org/plugins/stylelint-webpack-plugin/
 * @since 1.0.0
 */

module.exports = {
  plugins: [],
  rules: {
    "no-empty-source": null,
    "no-duplicate-selectors": true,

    "color-hex-length": "long",
    "function-url-quotes": "always",
    "font-family-name-quotes": "always-unless-keyword",
    "comment-whitespace-inside": "always",
    "selector-pseudo-element-colon-notation": "single",
    "selector-no-vendor-prefix": true,
    "property-no-vendor-prefix": true,
    "value-no-vendor-prefix": true,
    "media-feature-name-no-vendor-prefix": true,

    "unit-allowed-list":
      ["px", "em", "deg", "%", "vh", "vw", "s", "rem", "fr", "ms", "ch", "vmin", "vmax"],

    // Allow Tailwind v4 + common Tailwind at-rules
    "at-rule-no-unknown": [
      true,
      {
        ignoreAtRules: ["tailwind", "apply", "layer", "config", "plugin"],
      },
    ],
  },
};

