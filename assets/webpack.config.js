let Encore = require('@symfony/webpack-encore');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('../web/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './assets/app.js')
    .addStyleEntry('style', './assets/style.scss')
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .enablePostCssLoader((options) => {
        options.config = {
            path: 'postcss.config.js'
        };
    })
    .addLoader({
        test: /font-awesome\.config\.js/,
        use: [
            { loader: 'style-loader' },
            { loader: 'font-awesome-loader' }
        ]
    })
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
