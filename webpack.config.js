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
const CssnanoPlugin = require("cssnano-webpack-plugin");

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
          MiniCssExtractPlugin.loader,
          "css-loader",
          "postcss-loader",
          "resolve-url-loader",
          "sass-loader",
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
        test: /\.(ttf|eot|woff|woff2|svg)$/,
        use: {
          loader: "file-loader",
          options: {
            name: "[name].[ext]",
            outputPath: "../fonts/",
            esModule: false,
          },
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
    minimizer: [
      new CssnanoPlugin({
        test: /\.s?css$/i,
        cssnanoOptions: {
          preset: [
            "default",
            {
              discardComments: { removeAll: true },
            },
          ],
        },
      }),
      (compiler) => {
        const TerserPlugin = require("terser-webpack-plugin");
        new TerserPlugin({
          terserOptions: {
            compress: {},
          },
        }).apply(compiler);
      },
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
  devtool: "source-map",

  // ***** SET PLUGINS *****
  plugins: [
    // *** BROWSERSYNC ***
    new BrowserSyncPlugin({
      enable: true, // enable or disable browserSync
      host: "localhost",
      port: 3000,
      mode: "proxy", // proxy | server
      // * YOU NEED TO CHANGE THIS. VVV
      // * Local is going to output a Site Domain that ends in .local
      // * That needs to be pasted here to get Browersync to work properly.
      proxy: "https://prelaunch.local",
      // * CHANGE ME ^^^
      // BrowserSync will automatically watch for changes to any files connected to our entry,
      // including both JS and Sass files. We can use this property to tell BrowserSync to watch
      // for other types of files, in this case PHP files, in our project.
      files: "**/**/**.php",
      reload: true,
    }),

    // *** STYLELINT ***
    new StylelintPlugin(),

    // *** MINI CSS EXTRACT PLUGIN ***
    // * Lets get that CSS rolling. This plugin lets Webpack actually build a CSS file that's separate.
    // * If you want that file to be somewhere else, the path below will change that.
    // * The path is relative to output.path (the folder where frontend.js is).
    new MiniCssExtractPlugin({
      filename: "../css/frontend.css",
    }),
  ],
};
