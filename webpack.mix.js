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

mix.js('resources/js/app.js', 'public/js')
    //.less('resources/less/styles.less', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        //require('tailwindcss'),
    ]).postCss('resources/css/admin_styles.css', 'public/css', [
    ])
    .webpackConfig({
        module: {
            rules: [{
                test: /\.js?$/,
                exclude: /(bower_components)/,
                use: [{
                    loader: 'babel-loader',
                    options: mix.config.babel()
                }]
            }]
        }
    })
    .version();

//mix.js('resources/js/admin.js', 'public/js');
