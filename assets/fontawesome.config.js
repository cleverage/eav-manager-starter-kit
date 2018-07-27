module.exports = {
    styleLoader: require('extract-text-webpack-plugin').extract(
        {
            fallbackLoader: 'style-loader',
            loader: 'css-loader!sass-loader'
        }
    ),
    module: {
        loaders: [
            // the url-loader uses DataUrls.
            // the file-loader emits files.
            { test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "url-loader?limit=10000&mimetype=application/font-woff" },
            { test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "file-loader" }
        ]
    }
};
