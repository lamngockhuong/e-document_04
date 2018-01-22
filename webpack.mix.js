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

const WebpackShellPlugin = require('webpack-shell-plugin');

// Add shell command plugin configured to create JavaScript language file
mix.webpackConfig({
    plugins:
    [
        new WebpackShellPlugin({onBuildStart:['php artisan lang:js public/templates/dist/lang.dist.js --quiet'], onBuildEnd:[]})
    ]
});

/**
 * Public templates
 */
mix.js('resources/assets/js/e-document/app.js', 'public/templates/e-document/js')
    .sass('resources/assets/sass/e-document/app.scss', 'public/templates/e-document/css')
    .copy( 'resources/assets/templates/e-document', 'public/templates/e-document');

/**
 * Admin templates
 */
mix.js('resources/assets/js/admin/app.js', 'public/templates/admin/js')
    .sass('resources/assets/sass/admin/app.scss', 'public/templates/admin/css')
    .sass('resources/assets/sass/admin/custom.scss', 'public/templates/admin/css')
    .copy('node_modules/admin-lte/dist/css','public/templates/admin/css')
    .copy('node_modules/admin-lte/dist/img','public/templates/admin/img')
    .copy('node_modules/admin-lte/plugins','public/templates/admin/plugins')
    .copy( 'resources/assets/js/admin/custom.js', 'public/templates/admin/js')
    .copy( 'resources/assets/js/admin/auth.js', 'public/templates/admin/js');
