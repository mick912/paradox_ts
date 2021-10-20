module.exports = {
    configureWebpack: {
        module: {
            rules: [
                {
                    test: /\.js$/,
                    loader: 'string-replace-loader',
                    options: {
                        search: '__API_BASE_URL__',
                        replace: process.env.API_BASE_URL || 'http://localhost:8005/',
                        flags: 'g'
                    }
                }
            ]
        }
    },
    chainWebpack: config => {
        config
            .plugin('html')
            .tap(args => {
                args[0].title = "Paradox TS front-end";
                return args;
            })
    }
}