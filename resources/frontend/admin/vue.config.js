const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true
})
module.exports = {
    // proxy API requests to Valet during development
    devServer: {
        proxy: 'http://127.0.0.1:8000'
    },

    // output built static files to Laravel's public dir.
    // note the "build" script in package.json needs to be modified as well.
    outputDir: '../../../public/assets/admin',

    publicPath: process.env.NODE_ENV === 'production'
        ? '/assets/admin/'
        : '/admin',

    // modify the location of the generated HTML file.
    // make sure to do this only in production.
    indexPath: process.env.NODE_ENV === 'production'
        ? '../../../resources/views/admin.blade.php'
        : 'index.html'
}
