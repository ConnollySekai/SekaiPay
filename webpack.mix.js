const mix = require('laravel-mix');

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

mix.setPublicPath('public')
    .setResourceRoot('../')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/media-sm.scss', 'public/css')
    .sass('resources/sass/media-md.scss', 'public/css')
    .options({
        processCssUrls: false
    })
    .browserSync({
        proxy: 'http://127.0.0.1:8000'
    })
    .sourceMaps();
