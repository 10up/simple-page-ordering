const defaultConfig = require("10up-toolkit/config/webpack.config");
const DependencyExtractionWebpackPlugin = require("@wordpress/dependency-extraction-webpack-plugin");

module.exports = {
	...defaultConfig,
	plugins: [
		...defaultConfig.plugins.filter(
			(plugin) =>
				plugin.constructor.name !== "DependencyExtractionWebpackPlugin"
		),
		new DependencyExtractionWebpackPlugin({
			requestToExternal(request) {
				if ("jquery-ui-sortable" === request) {
					return "jquery-ui-sortable";
				}
			},
		}),
	],
};
