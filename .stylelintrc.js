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
    extends: 'stylelint-config-sass-guidelines',
    plugins: [
        "stylelint-scss",
    ],
    rules:   {
        "max-line-length":         180,
        "no-empty-source":         null,
        "at-rule-no-unknown":      null,
        "scss/at-rule-no-unknown": true,
        "indentation": 4,
        "string-quotes": "single",
        "no-duplicate-selectors": true,
        "color-hex-case": "upper",
        "color-hex-length": "long",
        "selector-combinator-space-after": "always",
        "selector-attribute-quotes": "always",
        "selector-attribute-operator-space-before": "always",
        "selector-attribute-operator-space-after": "always",
        "selector-attribute-brackets-space-inside": "never",
        "declaration-block-trailing-semicolon": "always",
        "declaration-colon-space-before": "never",
        "declaration-colon-space-after": "always",
        "property-no-vendor-prefix": true,
        "value-no-vendor-prefix": true,
        "number-leading-zero": "never",
        "function-url-quotes": "always",
        "font-family-name-quotes": "always-unless-keyword",
        "comment-whitespace-inside": "always",
        "rule-empty-line-before": "always",
        "selector-pseudo-element-colon-notation": "single",
        "selector-pseudo-class-parentheses-space-inside": "always",
        "selector-no-vendor-prefix": true,
        "unit-allowed-list": ["px", "em", "deg"],
        "media-feature-range-operator-space-before": "always",
        "media-feature-range-operator-space-after": "always",
        "media-feature-parentheses-space-inside": "never",
        "media-feature-name-no-vendor-prefix": true,
        "media-feature-colon-space-before": "never",
        "media-feature-colon-space-after": "always"
    },
    "ignoreFiles": [
        "./assets/public/css/**/*.css",
        "./vendor/**/**/*.css",
        "./node_modules/**/**/*.css",
        "./tests/**/**/*.css"
    ],
}