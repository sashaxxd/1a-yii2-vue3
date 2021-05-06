module.exports = {
    //Директория для билда
    outputDir: '../web/vue',
    productionSourceMap: false,
    filenameHashing: false,
    chainWebpack: config => {
        config.optimization.splitChunks(false);
    },
    configureWebpack: {
        // Для ssr
        entry: './src/entry.js'
        // entry: './src/main.js'
    }
}