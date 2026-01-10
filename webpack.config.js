// ****** THE WEBPACK CONFIG FILE ******
// *
// * I have commented this file heavily, almost to the point of making the code hard to read.
// * This is because I hated seeing guides online with barely any context as to what any of this did
// * You may not understand how to change this stuff, but hopefully you can at least see what its doing.

// ***** WEBPACK'S DEMANDS *****
// * Lol ok not really a list of demands but also kind of that.
// * This is where we tell Webpack what it needs to require.
const path = require("path");
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

// ***** MODULE EXPORTS *****
module.exports = {
  mode,

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
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
        },
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
          host: "localhost",
          port: 3000,
          mode: "proxy",
          proxy: "https://prelaunch.local",
          files: "**/**/**.php",
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
