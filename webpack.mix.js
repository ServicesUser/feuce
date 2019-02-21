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

mix
    .js('resources/js/app.js', 'public/js')
    .scripts(//tema
        [
            './node_modules/jquery/dist/jquery.js',
            "./node_modules/popper.js/dist/umd/popper.js",
            './node_modules/bootstrap/dist/js/bootstrap.min.js',
            './node_modules/bootstrap-select/js/bootstrap-select.js',
            './node_modules/bootstrap-select/js/i18n/defaults-es_ES.js',
            './node_modules/moment/moment.js',
            './node_modules/moment/locale/es.js',
            './node_modules/bootstrap-daterangepicker/daterangepicker.js',
            //'./node_modules/bootstrap-switch/dist/js/bootstrap-switch.js',
            './node_modules/owl.carousel/dist/owl.carousel.js',

            //'./node_modules/lightgallery.js/dist/js/lightgallery.js',
            //'./node_modules/lg-zoom/dist/js/lg-zoom.js',

            //'./node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js',
            './node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
            './node_modules/izitoast/dist/js/iziToast.min.js',
            './resources/sass/src/js/framework/base/app.js',
            './resources/sass/src/js/framework/base/util.js',
            './resources/sass/src/js/framework/components/general/*.js',
            './resources/sass/src/js/demo/demo8/base/layout.js',
            './resources/sass/src/js/app/base/main.js',


            //'./resources/assets/tema/js/snippets/base/quick-sidebar.js'

        ],
        './public/js/app.bundle.js'
    )
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({ devtool: "source-map" })
    .copyDirectory('resources/images', 'public/images/');
