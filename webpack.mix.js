let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.setPublicPath('./')

mix.js('resources/js/app.js', 'web/app/themes/events-theme/assets/scripts')
mix.sass('resources/css/app.scss', 'web/app/themes/events-theme/assets/styles')
mix.copy('resources/images', 'web/app/themes/events-theme/assets/images')
	// .copy('resources/fonts', 'web/app/themes/events-theme/assets/fonts')


mix.options({
	fileLoaderDirs: {
		fonts: '../app/themes/events-theme/assets/fonts',
		images: '../app/themes/events-theme/assets/images',
        
	}
})


if (mix.inProduction()) {
	mix.version()
} 
