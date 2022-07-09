const path = require('path');

module.exports = {
    entry: {
        'main': './app/src/main.ts',
        'ecwid': './app/src/ecwid.ts',
    },
    output: {
        filename: '[name].js',
        publicPath: '/',
        path: path.resolve(__dirname, '../dist/'),
    },
};