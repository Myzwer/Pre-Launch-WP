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
		"*.php",
		"./components/**/*.php",
		"./assets/src/js/**/*.{js,ts,jsx,tsx}",
	],
	plugins: [
		require("@tailwindcss/typography"),
		// Optional, but high ROI if you ever style raw form fields:
		// require("@tailwindcss/forms"),
	],
};
