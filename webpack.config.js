const path = require("path")
const CompressionPlugin = require("compression-webpack-plugin")
const { GenerateSW } = require("workbox-webpack-plugin")

module.exports = {
    resolve: {
        symlinks: false,
        alias: {
            "@": path.resolve("resources/js"),
        },
    },
    plugins: [
        new GenerateSW({
            swDest: "service-worker.js",
            clientsClaim: true,
            skipWaiting: true,
            runtimeCaching: [
                {
                    urlPattern: new RegExp("/"),
                    handler: "StaleWhileRevalidate",
                },
            ],
        }),
        new CompressionPlugin({
            test: /\.js$|\.css$|\.html$|\.svg$/,
            compressionOptions: {
                level: 9,
            },
            algorithm: "gzip",
            threshold: 10240,
            minRatio: 0.8,
        }),
    ],
}
