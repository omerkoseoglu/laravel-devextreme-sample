const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.combine('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js');
mix.combine('node_modules/devextreme/dist/js/dx.all.js', 'public/js/dx.all.js');
mix.combine([
    'node_modules/devextreme/dist/css/dx.common.css',
    'node_modules/devextreme/dist/css/dx.material.blue.light.compact.css'
], 'public/css/devextreme.css');
mix.combine('resources/js/custom-store.js', 'public/js/custom-store.js');

mix.copyDirectory("node_modules/devextreme/dist/css/icons", "public/css/icons");
mix.copyDirectory("node_modules/devextreme/dist/css/fonts", "public/css/fonts");


mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
