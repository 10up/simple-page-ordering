const path = require('path');

module.exports = {
	entry: {
		'simple-page-ordering': './assets/js/src/simple-page-ordering.js',
	},
	output: {
		filename: '[name].min.js',
		path: path.resolve('./assets/js')
	},
	resolve: {
		modules: ['node_modules'],
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env'],
					}
				},
			},
		],
	}
};
