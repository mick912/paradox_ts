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
    }
}