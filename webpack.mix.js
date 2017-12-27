let mix = require('laravel-mix');

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

// mix.options({ processCssUrls: false });

/**
 * Public templates
 */

mix.js('resources/assets/js/e-document/index.js', 'public/templates/e-document/js')
    .sass('resources/assets/sass/e-document/index.scss', 'public/templates/e-document/css');
mix.copy( 'resources/assets/templates/e-document', 'public/templates/e-document');

/**
 * Admin templates
 */
mix.js('resources/assets/js/admin/index.js', 'public/templates/admin/js')
    .sass('resources/assets/sass/admin/index.scss', 'public/templates/admin/css');
