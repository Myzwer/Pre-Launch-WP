/**
 * Stylelint config file
 * as configured in package.json under stylelint.extends
 *
 * @docs Stylelint https://stylelint.io/user-guide/
 * @docs StylelintWebpackPlugin: https://webpack.js.org/plugins/stylelint-webpack-plugin/
 * @docs stylelint-scss : https://github.com/kristerkari/stylelint-scss
 * @since 1.0.0
 */

module.exports = {
  extends: ["stylelint-config-sass-guidelines", "stylelint-config-prettier"],
  plugins: ["stylelint-scss"],
  rules: {
    "no-empty-source": null,
    "at-rule-no-unknown": null,
    "scss/at-rule-no-unknown": true,
    "no-duplicate-selectors": true,
    "color-hex-length": "long",
    "selector-attribute-quotes": "always",
    "selector-attribute-operator-space-before": "never",
    "selector-attribute-operator-space-after": "never",
    "selector-attribute-brackets-space-inside": "never",
    "property-no-vendor-prefix": true,
    "value-no-vendor-prefix": true,
    "function-url-quotes": "always",
    "font-family-name-quotes": "always-unless-keyword",
    "comment-whitespace-inside": "always",
    "selector-pseudo-element-colon-notation": "single",
    "selector-no-vendor-prefix": true,
    "unit-allowed-list": ["px", "em", "deg", "%", "vh", "s"],
    "media-feature-range-operator-space-before": "always",
    "media-feature-range-operator-space-after": "always",
    "media-feature-parentheses-space-inside": "never",
    "media-feature-name-no-vendor-prefix": true,
    "media-feature-colon-space-before": "never",
    "media-feature-colon-space-after": "always",
  },
};
