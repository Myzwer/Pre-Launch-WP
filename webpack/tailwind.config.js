/**
 * Tailwind CSS configuration.
 *
 * Defines content scanning paths, theme customization,
 * and official Tailwind plugins used by the project.
 *
 * @docs https://tailwindcss.com/docs/configuration
 */

module.exports = {
	content: [
		"./**/*.php", // all theme php (root, template-parts, inc, etc.)
		"./assets/src/**/*.{css,js,ts,jsx,tsx}", // scan CSS + JS/TS for class usage
	],
	plugins: [
		require("@tailwindcss/typography"),
	],
};
