const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [require("postcss-import")])
    .postCss("resources/css/app_admin.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss")
    ])
    .js("resources/js/admin_parts/donations.js", "public/js")
    .js("resources/js/parts/scheduled-qurbani.js", "public/js")
    .sass("resources/sass/admin/admin.scss", "public/css", [])
    .postCss("resources/css/mobile.css", "public/css", [])

    // TinyMCE
    .js(
        "node_modules/tinymce/themes/silver/theme.js",
        "public/js/themes/silver"
    )
    .js(
        "node_modules/tinymce/plugins/table/plugin.js",
        "public/js/plugins/table"
    )
    .js(
        "node_modules/tinymce/plugins/image/plugin.js",
        "public/js/plugins/image"
    )
    .js(
        "node_modules/tinymce/plugins/lists/plugin.js",
        "public/js/plugins/lists"
    )
    .js("node_modules/tinymce/plugins/hr/plugin.js", "public/js/plugins/hr")
    .js("node_modules/tinymce/plugins/code/plugin.js", "public/js/plugins/code")
    .js("node_modules/tinymce/plugins/link/plugin.js", "public/js/plugins/link")
    .js(
        "node_modules/tinymce/plugins/media/plugin.js",
        "public/js/plugins/media"
    )
    .js(
        "node_modules/tinymce/plugins/imagetools/plugin.js",
        "public/js/plugins/imagetools"
    )
    .js(
        "node_modules/tinymce/icons/default/icons.js",
        "public/js/icons/default"
    )
    .styles(
        ["node_modules/tinymce/skins/ui/oxide/skin.min.css"],
        "public/js/skins/ui/oxide/skin.min.css"
    )
    .styles(
        ["node_modules/tinymce/skins/ui/oxide/content.min.css"],
        "public/js/skins/ui/oxide/content.min.css"
    )
    .styles(
        ["node_modules/tinymce/skins/content/default/content.css"],
        "public/js/skins/content/default/content.css"
    )
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.js?$/,
                    exclude: /(bower_components)/,
                    use: [
                        {
                            loader: "babel-loader",
                            options: mix.config.babel()
                        }
                    ]
                }
            ]
        }
    })

    .version();

mix.js("resources/js/admin_parts/media-manager.js", "public/js/widgets");

// MediaManager
mix.sass(
    "resources/assets/vendor/MediaManager/sass/manager.scss",
    "public/assets/vendor/MediaManager/style.css"
).copyDirectory(
    "resources/assets/vendor/MediaManager/dist",
    "public/assets/vendor/MediaManager"
);
