const Encore = require('@symfony/webpack-encore');

Encore
    // Directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // Public path used by the web server to access the output path
    .setPublicPath('/build')
    // Main entry point for the app
    .addEntry('app', './assets/app.js')

    // Enable Single Runtime Chunk
    .enableSingleRuntimeChunk()

    // Enable Sass/SCSS support
    .enableSassLoader()

    // Enable Vue.js support
    .enableVueLoader()

    // Other Webpack configurations...
;

module.exports = Encore.getWebpackConfig();
