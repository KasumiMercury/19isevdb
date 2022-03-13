const path = require("path")
const CompressionPlugin = require("compression-webpack-plugin")

module.exports = {
    resolve: {
        symlinks: false,
        alias: {
            "@": path.resolve("resources/js"),
        },
    },
    plugins: [
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
