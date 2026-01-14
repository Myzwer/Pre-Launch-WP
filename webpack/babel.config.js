/**
 * Babel configuration.
 *
 * Transpiles modern JavaScript and TypeScript for browser compatibility.
 * Used by Webpack to process frontend source files.
 *
 * @docs https://babeljs.io/docs/
 */


module.exports = {
  presets: ["@babel/preset-env", "@babel/preset-typescript"],
};
