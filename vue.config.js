const { defineConfig } = require('@vue/cli-service')
const path = require('path');
module.exports = defineConfig({
  transpileDependencies: true,
  css: {sourceMap: true},
   publicPath: "/",
   indexPath:"resources/views/welcome.blade.php",
   assetsDir:"public",
   outputDir: 'public',
   pages: {
      index: {
        entry:"resources/js/app.js",
        template:"resources/views/welcome.blade.php",
      }
    },
    configureWebpack: {
      resolve: {
          alias: {
              '@src': path.join(__dirname, 'src'),
              
              //'@/assets': path.join(__dirname, 'public/assets'),
              //'@/data': path.join(__dirname, 'public/data'),
             
             //'@/mixins':path.join(__dirname, 'resources/js/mixins'),
             '@': path.join(__dirname, 'resources/js'),
          }
      }
  },
   devServer: {
    proxy: 'http://localhost:8080'
  }
})
