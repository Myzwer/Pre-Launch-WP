/**
 * ESLint's configuration.
 *
 * Defines JavaScript and TypeScript linting rules for this project.
 * Focused on correctness and best practices; formatting is handled
 * separately by editor tooling and Prettier.
 *
 * @docs https://eslint.org/docs/latest/
 */


module.exports = {
	parser: "@babel/eslint-parser",

	env: {
		browser: true,
		es2021: true,
	},

	// Base ruleset + Prettier compatibility
	extends: ["google", "prettier"],

	parserOptions: {
		ecmaVersion: 12,
		sourceType: "module",
	},

	rules: {
		// Keep lines readable
		"max-len": [2, 120, 4, { ignoreUrls: true }],

		// Turned off because WP editing
		"no-invalid-this": "off",
	},

	// Globals provided by WordPress and legacy scripts.
	globals: {
		wp: true,
		jQuery: true,
	},

	// Files and paths that should never be linted.
	ignorePatterns: [
		"tests/**/*.js",
		"temp.js",
		"/vendor/**/**/*.js",
		"/node_modules/**/**/*.js",
		"/assets/public",
		"../readme.md",
	],
};
