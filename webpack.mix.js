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

mix.js('resources/js/vendor.js', 'public/js')
    .js('resources/js/ckeditor.js', 'public/js/ckeditor.js')
    .js('resources/js/app/user.js', 'public/js/user.js')
    .js('resources/js/app/role.js', 'public/js/role.js')
    .js('resources/js/app/api.js', 'public/js/api.js')
    .js('resources/js/app/branch.js', 'public/js/branch.js')
    .js('resources/js/app/customer.js', 'public/js/customer.js')

    .sass('resources/sass/vendor.scss', 'public/css/')
    .sass('resources/sass/sale.scss', 'public/css/sale.css')
    //.copyDirectory('resources/plugins','public/plugins')
.sourceMaps();
