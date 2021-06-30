// ***** WEBPACK'S DEMANDS *****
// * Not really a list of demands but also kind of that. This is where we tell Webpack what it needs to require.
const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');


// ***** SET ENVIRONMENT *****
// * This tells webpack to always run in development mode.
let mode = 'development';

// * This tells webpack that if we switch the node env (For n00bs: we run 'yarn run prod' in terminal), to switch it to
// * production mode instead, which minifies, mangles, etc our code.
if (process.env.NODE_ENV === 'production') {
  mode = 'production';
}


// ***** MODULE EXPORTS *****
module.exports = {
  mode: mode,

  module: {
    rules: [
      {
        test: /\.s?css$/i,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'postcss-loader',
          'sass-loader',
        ],
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },


  // * This is how to change entry location as well as output location and name
  entry: './assets/src/js/frontend.js',
  output: {
    filename: 'frontend.js',
    path: path.resolve(__dirname, 'assets/public/js'),
  },

  // ***** SET DEVTOOL *****
  // * What else can you set this to?
  // * https://webpack.js.org/configuration/devtool/
  devtool: 'source-map',


  // ***** SET PLUGINS *****
  plugins: [
    new BrowserSyncPlugin(
        // BrowserSync options
        {
          // browse to http://localhost:3000/ during development
          host: 'localhost',
          port: 3000,
          // proxy the Webpack Dev Server endpoint
          // (which should be serving on http://localhost:3100/)
          // through BrowserSync

          // YOU NEED TO CHANGE THIS. Local is going to output a Site Domain that ends in .local
          // That needs to be pasted here to get Browersync to work properly.
          proxy: 'prelaunch.local',
        },
        // plugin options
        {
          // prevent BrowserSync from reloading the page
          // and let Webpack Dev Server take care of this
          reload: false,
        },
    ),


    // * Lets get that CSS rolling. This plugin lets Webpack actually build a CSS file that's separate.
    // * If you want that file to be somewhere else, the path below will change that.
    // * The path is relevant to output.path (the folder where frontend.js is).
    new MiniCssExtractPlugin({
      filename: '../css/frontend.css',
    }),
  ],
};
