const {merge} = require('webpack-merge');

const customModules = require("./config/webpack.modules.js");
const customAliases = require("./config/webpack.aliases.js");
const customPlugins = require("./config/webpack.plugins.js");

const devServer = require("./config/webpack.devServer.js");

const appEntry = require("./config/app.entry.js");

const common = merge(customModules, customAliases, customPlugins, devServer);

module.exports = [
  merge(appEntry, common),
];