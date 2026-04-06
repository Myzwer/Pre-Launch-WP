// ***** WEBPACK CONFIG *****
// Minimal, stable Webpack 5 config for this starter theme.

// ***** REQUIRED PLUGINS *****
const path = require("path");
const fs = require("fs");
const dotenv = require("dotenv");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const StylelintPlugin = require("stylelint-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");

// ***** SET BUILD MODE *****
// Defaults to development; production is enabled via NODE_ENV=production.
let mode = "development";

if (process.env.NODE_ENV === "production") {
	mode = "production";
}

// ***** LOAD .ENV (DEV ONLY) *****
// Loads .env, then .env.local (local overrides).
if (mode === "development") {
	const envFiles = [".env", ".env.local"];

	envFiles.forEach((file) => {
		const fullPath = path.resolve(__dirname, file);
		if (fs.existsSync(fullPath)) {
			dotenv.config({path: fullPath, override: true});
		}
	});
}

// ***** BROWSERSYNC DEFAULTS *****
// Can be overridden via .env / .env.local.
const BS_HOST = process.env.BROWSERSYNC_HOST || "localhost";
const BS_PORT = Number(process.env.BROWSERSYNC_PORT || 3000);
const BS_PROXY = process.env.BROWSERSYNC_PROXY || "https://prelaunch.local";
const BS_FILES = process.env.BROWSERSYNC_FILES || "**/**/**.php";

module.exports = {
	mode,

	// ***** WEBPACK FILESYSTEM CACHE *****
	// Speeds up rebuilds by caching module processing results to disk.
	cache: {
		type: "filesystem",
		cacheDirectory: path.resolve(__dirname, ".cache/webpack"),

		// Separate cache by mode so dev/prod don’t fight each other.
		name: mode,

		// Invalidate cache when webpack.config.js changes.
		buildDependencies: {
			config: [__filename],
		},
	},

	// ***** MODULE RULES *****
	module: {
		rules: [
			// ***** CSS (POSTCSS PIPELINE) *****
			{
				test: /\.css$/i,
				use: [
					{loader: MiniCssExtractPlugin.loader},

					{
						loader: "css-loader",
						options: {
							sourceMap: mode !== "production",
							importLoaders: 1, // ensure @import files also run through postcss-loader
						},
					},

					{
						loader: "postcss-loader",
						options: {
							sourceMap: mode !== "production",
							postcssOptions: {
								config: "./webpack/postcss.config.js",
							},
						},
					},
				],
			},

			// ***** JS/TS (BABEL) *****
			{
				test: /\.[jt]sx?$/,
				exclude: /node_modules/,
				use: {loader: "babel-loader"},
			},

			// ***** FONTS (ASSET MODULES) *****
			{
				test: /\.(ttf|eot|woff|woff2|svg)$/i,
				type: "asset/resource",
				generator: {
					filename: "../fonts/[name][ext]",
				},
			},
		],
	},

	// ***** OPTIMIZATION (PROD MINIFY) *****
	// Production builds minify JS (Terser) + CSS (css-minimizer / cssnano preset).
	optimization: {
		minimize: mode === "production",
		minimizer: [
			new TerserPlugin({
				terserOptions: {
					compress: {},
				},
			}),
			new CssMinimizerPlugin({
				minimizerOptions: {
					preset: [
						"default",
						{
							discardComments: {removeAll: true},
						},
					],
				},
			}),
		],
	},

	// ***** ENTRY / OUTPUT *****
	resolve: {
		extensions: [".ts", ".tsx", ".js", ".jsx", ".json"],
	},

	entry: {
		frontend: "./assets/src/js/frontend.ts",
		blocks: "./assets/src/js/blocks.ts",
	},
	output: {
		filename: "[name].js",
		path: path.resolve(__dirname, "assets/public/js"),
	},

	// ***** SOURCE MAPS *****
	// Dev uses fast eval maps; prod outputs full source-map files.
	devtool: mode === "production" ? "source-map" : "eval-cheap-module-source-map",

	// ***** PLUGINS *****
	plugins: [
		...(mode === "development"
			? [
				new BrowserSyncPlugin({
					enable: true,
					host: BS_HOST,
					port: BS_PORT,
					mode: "proxy",
					proxy: BS_PROXY,
					files: BS_FILES,
					reload: true,
				}),
				new StylelintPlugin({
					files: ["assets/src/css/**/*.css"],
					exclude: ["assets/src/vendor/**", "**/node_modules/**"],
				}),
			]
			: []),

		new MiniCssExtractPlugin({
			filename: "../css/[name].css",
		}),

		new CopyWebpackPlugin({
			patterns: [
				{
					from: "assets/src/vendor/fontawesome",
					to: "../vendor/fontawesome",
					noErrorOnMissing: true,
				},
				{
					from: "assets/src/img",
					to: "../img",
					noErrorOnMissing: true,
				},
			],
		}),
	],
};
