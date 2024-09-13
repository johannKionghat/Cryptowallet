const Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where Webpack should put the build files
    .setOutputPath('public/build/')
    // the public path used by the web server to access the output path
    .setPublicPath('/build')
    // the main JavaScript entry point
    .addEntry('app', './assets/app.js')
    // enable source maps during development
    .enableSourceMaps(!Encore.isProduction())
    // enable React support
    .enableReactPreset()
    // enable Sass/Scss support
    .enableSassLoader()
    // enable Vue.js support
    .enableVueLoader()
    // other configurations...
;

module.exports = Encore.getWebpackConfig();
