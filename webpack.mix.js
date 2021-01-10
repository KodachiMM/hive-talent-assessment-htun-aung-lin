const mix = require('laravel-mix');
const ChunkRenamePlugin = require('webpack-chunk-rename-plugin');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/admin/app.js', 'app.js')
    .extract(['vue', 'axios', 'vee-validate', 'vue-notification'], 'vendor.js')
    .webpackConfig({
		plugins: [ 
			new ChunkRenamePlugin({
				initialChunksWithEntry: true,
				'/app': 'js/admin/app.js',
				'/vendor': 'js/admin/vendor.js',
			})
		],
		output: {
			filename: (chunkData) => {
				return chunkData.chunk.name === '/manifest' ? 'js/admin/manifest.js' : 'js/admin/[name].js';
			},
			chunkFilename: mix.inProduction() ? 'js/admin/chunks/[name].[chunkhash].js' : 'js/admin/chunks/[name].js'
        },
    });
