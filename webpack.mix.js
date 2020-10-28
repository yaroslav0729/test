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

    // TinyMCE
    .js('node_modules/tinymce/themes/silver/theme.js', 'public/js/themes/silver')
    .js('node_modules/tinymce/plugins/table/plugin.js', 'public/js/plugins/table')
    .js('node_modules/tinymce/plugins/image/plugin.js', 'public/js/plugins/image')
    .js('node_modules/tinymce/plugins/lists/plugin.js', 'public/js/plugins/lists')
    .js('node_modules/tinymce/plugins/hr/plugin.js', 'public/js/plugins/hr')
    .js('node_modules/tinymce/plugins/code/plugin.js', 'public/js/plugins/code')
    .js('node_modules/tinymce/plugins/link/plugin.js', 'public/js/plugins/link')
    .js('node_modules/tinymce/plugins/media/plugin.js', 'public/js/plugins/media')
    .js('node_modules/tinymce/icons/default/icons.js', 'public/js/icons/default')
    .styles(['node_modules/tinymce/skins/ui/oxide/skin.min.css'], 'public/js/skins/ui/oxide/skin.min.css')
    .styles(['node_modules/tinymce/skins/ui/oxide/content.min.css'], 'public/js/skins/ui/oxide/content.min.css')
    .styles(['node_modules/tinymce/skins/content/default/content.css'], 'public/js/skins/content/default/content.css')
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
