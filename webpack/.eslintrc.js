module.exports = {
  parser: "@babel/eslint-parser",
  env: {
    browser: true,
    es2021: true,
  },
  extends: ["google", "prettier"],
  parserOptions: {
    ecmaVersion: 12,
    sourceType: "module",
  },
  rules: {
    "max-len": [2, 120, 4, { ignoreUrls: true }],
  },
  globals: {
    wp: true,
    jQuery: true,
  },
  ignorePatterns: [
    "tests/**/*.js",
    "temp.js",
    "/vendor/**/**/*.js",
    "/node_modules/**/**/*.js",
    "/assets/public",
    "../readme.md",
  ],
};
