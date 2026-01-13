/**
 * Tailwind CSS configuration.
 *
 * Defines content scanning paths, theme customization,
 * and official Tailwind plugins used by the project.
 *
 * @docs https://tailwindcss.com/docs/configuration
 */

module.exports = {
	// Files Tailwind scans for class usage.
	content: [
		"*.php",
		"./components/**/*.php",
		"./assets/src/js/**/*.{js,ts,jsx,tsx}",
	],

	theme: {
		// Custom breakpoint definitions.
		screens: {
			sm: "39.9375em",
			md: "63.9375em",
			lg: "64em",
			xl: "74.9375em",
		},

		// Common CSS keyword values.
		transparent: "transparent",
		current: "currentColor",

		// Project color palette.
		colors: {
			blue: {
				light: "#6495ED",
				DEFAULT: "#0047AB",
				dark: "#00008B",
				100: "#ff0000",
			},
			pink: {
				light: "#ff7ce5",
				DEFAULT: "#ff49db",
				dark: "#ff16d1",
			},
			gray: {
				darkest: "#1f2d3d",
				dark: "#3c4858",
				DEFAULT: "#c0ccda",
				light: "#e0e6ed",
				lightest: "#f9fafc",
			},
			white: {
				DEFAULT: "#ffffff",
			},
			black: {
				DEFAULT: "#000000",
			},
		},
	},

	// Official Tailwind plugins used by the project.
	plugins: [require("@tailwindcss/typography")],
};
