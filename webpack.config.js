let Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
    .configureFilenames({
        images: '[path][name].[hash:8].[ext]',
    })

    // uncomment to define the assets of the project
    .addEntry('app', './assets/js/app.js')
    //.addEntry('js/app', './assets/js/app.js')
    //.addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()
    .enableReactPreset()
    .enablePostCssLoader((options) => {
         options.config = {
             path: 'config/postcss.config.js',
         };
    })
    .configureBabel(function(babelConfig) {
        babelConfig.plugins.push('react-html-attrs');
        babelConfig.plugins.push('transform-class-properties');
        babelConfig.plugins.push('transform-decorators-legacy');
    })
;


module.exports = Encore.getWebpackConfig();

require('fs').writeFileSync("var/cache/generatedWebpackConfig.txt", JSON.stringify(module.exports, null, 2));