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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/js/sidebar-pro/img/*.*', 'public/images/sidebar-pro')
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .copyDirectory('node_modules/@mdi/font/fonts/', 'public/fonts')
    .copyDirectory('node_modules/material-icons/iconfont', 'public/iconfont')
    //.copyDirectory('node_modules/material-design-icons/iconfont', 'public/iconfont')
    .options({
        processCssUrls: false,
    });
