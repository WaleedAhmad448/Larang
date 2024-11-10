// const webpack = require('webpack');

// module.exports = {
//   resolve: {
//     fallback: {
//       "http": require.resolve("stream-http"),
//       "https": require.resolve("stream-http"),
//       "path": require.resolve("path-browserify"),
//       "fs": false,
//       "stream": require.resolve("stream-browserify"),
//       "util": require.resolve("util/"),
//       "querystring": require.resolve("querystring-es3"),
//       "zlib": require.resolve("browserify-zlib"),
//       "async_hooks": false
//     }
//   },
//   plugins: [
//     new webpack.ProvidePlugin({
//       process: 'process/browser',
//       Buffer: ['buffer', 'Buffer'],
//     }),
//   ],
// };