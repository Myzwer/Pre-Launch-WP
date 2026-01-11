// ****** THE WEBPACK CONFIG FILE ******
// *
// * I have commented this file heavily, almost to the point of making the code hard to read.
// * This is because I hated seeing guides online with barely any context as to what any of this did
// * You may not understand how to change this stuff, but hopefully you can at least see what its doing.

// ***** WEBPACK'S DEMANDS *****
// * Lol ok not really a list of demands but also kind of that.
// * This is where we tell Webpack what it needs to require.
const path = require("path");
const fs = require("fs");
const dotenv = require("dotenv");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const StylelintPlugin = require("stylelint-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");

// ***** SET ENVIRONMENT *****
// * This tells webpack to always run in development mode.
let mode = "development";

// * This tells webpack that if we switch the node env (For n00bs: we run 'yarn run prod' in terminal), to switch it to
// * production mode instead, which minifies, mangles, etc our code.
if (process.env.NODE_ENV === "production") {
  mode = "production";
}

// ***** LOAD .ENV (DEV ONLY) *****
// Order: .env then .env.local (local overrides base)
if (mode === "development") {
  const envFiles = [".env", ".env.local"];

  envFiles.forEach((file) => {
    const fullPath = path.resolve(__dirname, file);
    if (fs.existsSync(fullPath)) {
      dotenv.config({ path: fullPath, override: true });
    }
  });
}

// ***** BROWSERSYNC DEFAULTS *****
// Matches your current hardcoded values unless overridden in .env
const BS_HOST = process.env.BROWSERSYNC_HOST || "localhost";
const BS_PORT = Number(process.env.BROWSERSYNC_PORT || 3000);
const BS_PROXY = process.env.BROWSERSYNC_PROXY || "https://prelaunch.local";
const BS_FILES = process.env.BROWSERSYNC_FILES || "**/**/**.php";


// ***** MODULE EXPORTS *****
module.exports = {
  mode,

  // ***** WEBPACK FILESYSTEM CACHE *****
  // * Speeds up rebuilds by caching module processing results to disk.
  // * Safe + predictable for a “stable for 2+ years” template.
  cache: {
    type: "filesystem",

    // Keep cache inside the repo (not node_modules) so it works with Yarn Berry / PnP setups too.
    cacheDirectory: path.resolve(__dirname, ".cache/webpack"),

    // Separate cache by mode so dev/prod don’t fight each other.
    name: mode,

    // Invalidate cache when webpack.config.js changes
    buildDependencies: {
      config: [__filename],
    },
  },

  module: {
    rules: [
      // *** CSS ***
      {
        test: /\.s?css$/i,
        use: [
          { loader: MiniCssExtractPlugin.loader },

          {
            loader: "css-loader",
            options: { sourceMap: mode !== "production" },
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

          {
            loader: "resolve-url-loader",
            options: { sourceMap: mode !== "production" },
          },

          {
            loader: "sass-loader",
            // Keep this true so resolve-url-loader always has what it needs
            // (even if you change other sourceMap settings later)
            options: { sourceMap: true },
          },
        ],
      },


      // *** BABEL ***
      {
        test: /\.[jt]sx?$/,
        exclude: /node_modules/,
        use: { loader: "babel-loader" },
      },

      // *** FONTS ***
      {
        test: /\.(ttf|eot|woff|woff2|svg)$/i,
        type: "asset/resource",
        generator: {
          filename: "../fonts/[name][ext]",
        },
      },
    ],
  },

  // * Minimization!
  // * So this is where CSSNano is configured to minimize our CSS.
  // * It does a few extra goodies like removing comments and stuff
  // * Currently using default settings. More on that here:
  // * https://cssnano.co/docs/optimisations
  // * This is also where we ping TerserPlugin to minify our JS too.
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
              discardComments: { removeAll: true },
            },
          ],
        },
      }),
    ],
  },


  // *** INPUT / OUTPUT ***
  // * This is how to change entry location as well as output location and name
  // * Relative to this file, tell it where your js is coming from and where its going.

  resolve: {
    extensions: [".ts", ".tsx", ".js", ".jsx", ".json"],
  },

  entry: "./assets/src/js/frontend.js",
  output: {
    filename: "frontend.js",
    path: path.resolve(__dirname, "assets/public/js"),
  },

  // ***** SET DEVTOOL *****
  // * What else can you set this to?
  // * https://webpack.js.org/configuration/devtool/
  devtool: mode === "production" ? "source-map" : "eval-cheap-module-source-map",


  // ***** SET PLUGINS *****
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
        new StylelintPlugin(),
      ]
      : []),

    new MiniCssExtractPlugin({
      filename: "../css/frontend.css",
    }),
  ],
};
