const path = require('path');

module.exports = {
    devServer: {
        index: 'index.html',
        contentBase: path.join(__dirname, '../dist'),
        compress: true,
        host: '0.0.0.0',
        port: 9001,
        open: false,
        historyApiFallback: {
            rewrites: [
                { from: /^\//, to: '/' }
            ]
        }
    }
};