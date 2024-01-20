const mix = require('laravel-mix')
// const exec = require('child_process').exec
// require('dotenv').config()

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

const glob = require('glob')
// const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Vendor assets
 |--------------------------------------------------------------------------
 */

function mixAssetsDir(query, cb) {
    ; (glob.sync('resources/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/')
        cb(f, f.replace('resources/assets', 'public/assets'))
    })
}

const sassOptions = {
    precision: 5,
    includePaths: ['node_modules', 'resources/assets/admin/assets/']
}

// plugins Core stylesheets
mixAssetsDir('assets/admin/scss/base/plugins/**/!(_)*.scss', (src, dest) =>
    mix.sass(src, dest.replace(/(\\|\/)scss(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions })
)

// pages Core stylesheets
// mixAssetsDir('scss/base/pages/**/!(_)*.scss', (src, dest) =>
//     mix.sass(src, dest.replace(/(\\|\/)scss(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), {sassOptions})
// )
mixAssetsDir('assets/admin/scss/base/pages/authentication.scss', (src, dest) =>
    mix.sass(src, dest.replace(/(\\|\/)scss(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions })
)

// Core stylesheets
mixAssetsDir('assets/admin/scss/base/core/**/!(_)*.scss', (src, dest) =>
    mix.sass(src, dest.replace(/(\\|\/)scss(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions })
)

// script js
mixAssetsDir('assets/admin/js/scripts/**/*.js', (src, dest) => mix.scripts(src, dest))

/*
 |--------------------------------------------------------------------------
 | Application assets
 |--------------------------------------------------------------------------
 */

function checkResource(src) {
    return src.indexOf('resources/assets/admin/vendors/js/editors/') !== -1 ||
        src.indexOf('resources/assets/admin/vendors/js/tables/datatable') !== -1 ||
        src.indexOf('resources/assets/admin/vendors/js/forms/cleave/addons/cleave-phone') !== -1;
    // || (src.indexOf('resources/vendors/js/forms/cleave/addons/cleave-phone') !== -1
    //     && src.indexOf("cleave-phone.vi.js") === -1
    //     && src.indexOf("cleave-phone.vn.js") === -1);
}

mixAssetsDir('assets/admin/vendors/js/**/*.js', function (src, dest) {
    if (!checkResource(src)) {
        mix.scripts(src, dest);
    }
})
mixAssetsDir('assets/admin/vendors/css/**/*.css', function (src, dest) {
    if (!checkResource(src)) {
        mix.copy(src, dest);
    }
})
mixAssetsDir('assets/admin/vendors/**/**/images', (src, dest) => mix.copy(src, dest))
mixAssetsDir('assets/admin/vendors/css/editors/quill/fonts/', (src, dest) => mix.copy(src, dest))
mixAssetsDir('assets/admin/fonts/feather', (src, dest) => mix.copy(src, dest))
mixAssetsDir('assets/admin/fonts/font-awesome', (src, dest) => mix.copy(src, dest))
mixAssetsDir('assets/admin/fonts/**/**/*.css', (src, dest) => mix.copy(src, dest))
mixAssetsDir('assets/admin/images', (src, dest) => mix.copy(src, dest))

//tinymce
mix.copy(`node_modules/tinymce/themes`, 'public/assets/admin/vendors/js/wysiwyg/themes')
    .copy(`node_modules/tinymce/skins`, 'public/assets/admin/vendors/js/wysiwyg/skins')
    .copy(`node_modules/tinymce/icons`, 'public/assets/admin/vendors/js/wysiwyg/icons')
    ;
let tinymcePlugins = [
    'lists',
    'link',
    'table',
    'image',
    'media',
    'paste',
    'autosave',
    'autolink',
    'wordcount',
    'code',
    'fullscreen',
];

tinymcePlugins.forEach(plugin => {
    mix.copy(`node_modules/tinymce/plugins/${plugin}/plugin.js`, `public/assets/admin/vendors/js/wysiwyg/plugins/${plugin}`);
});

mix
    .js('resources/assets/admin/js/core/app-menu.js', 'public/assets/admin/js/core')
    .js('resources/assets/admin/js/core/app.js', 'public/assets/admin/js/core')
    .js('resources/assets/frontend/js/app.js', 'public/assets/frontend/js')
    .js('resources/assets/frontend/js/chapter.js', 'public/assets/frontend/js')
    .js('resources/assets/frontend/js/story.js', 'public/assets/frontend/js')
    .js('resources/assets/frontend/js/common.js', 'public/assets/frontend/js')
    // .js('resources/assets/admin/assets/js/wysiwyg.js', 'public/assets/admin/js/core')
    .js('resources/assets/admin/assets/js/scripts.js', 'public/assets/admin/js/core')
    .sass('resources/assets/admin/scss/base/themes/semi-dark-layout.scss', 'public/assets/admin/css/base/themes', { sassOptions })
    .sass('resources/assets/admin/scss/core.scss', 'public/assets/admin/css', { sassOptions })
    .sass('resources/assets/admin/scss/overrides.scss', 'public/assets/admin/css', { sassOptions })
    .sass('resources/assets/admin/assets/scss/style.scss', 'public/assets/admin/css', { sassOptions })

    .sass('resources/assets/frontend/scss/app.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/global.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/header.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/list_category.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/stories_full.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/stories_hot.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/story_item_full.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/story_item_list.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/story_item_no_image.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/story_item.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/chapter.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/story_detail.scss', 'public/assets/frontend/css/app.css')
    .sass('resources/assets/frontend/scss/top_ratings.scss', 'public/assets/frontend/css/app.css')

    .version()

mix.copyDirectory(`${__dirname}/resources/assets/frontend/libs`, 'public/assets/frontend/libs')
mix.copyDirectory(`${__dirname}/resources/assets/frontend/images`, 'public/assets/frontend/images')

//mix all file scss
// mixAssetsDir('assets/frontend/scss/**/!(_)*.scss', (src, dest) =>
//     mix.sass(src, dest.replace(/(\\|\/)scss(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions }).version()
// )

// mixAssetsDir('assets/frontend/js/**/!(_)*.js', function (src, dest) {
//     if (!checkResource(src)) {
//         mix.scripts(src, dest).version();
//     }
// })