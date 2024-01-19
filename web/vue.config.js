const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
    transpileDependencies: true,
    lintOnSave: false,
    publicPath: process.env.NODE_ENV!=='development'?'./':'/',
    devServer: {
        open: true, // 编译后默认打开浏览器
        host: '0.0.0.0',  // 域名
        port: 8080,  // 端口
        https: false,  // 是否https
        // 显示警告和错误
        client: {
            overlay: {
                warnings: false,
                errors: true
            },
        },
        proxy: 'http://localhost'
    }
})
