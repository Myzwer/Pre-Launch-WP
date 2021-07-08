module.exports = {
	parser: '@babel/eslint-parser',
	env: {
		browser: true,
		es2021: true,
	},
	extends: ['google', 'plugin:@wordpress/eslint-plugin/recommended'],
	parserOptions: {
		ecmaVersion: 12,
		sourceType: 'module',
	},
	rules: {
		'max-len': [2, 120, 4, { ignoreUrls: true }],
	},
	globals: {
		wp: true,
		jQuery: true,
	},
	ignorePatterns: [
		'tests/**/*.js',
		'temp.js',
		'/vendor/**/**/*.js',
		'/node_modules/**/**/*.js',
	],
};
