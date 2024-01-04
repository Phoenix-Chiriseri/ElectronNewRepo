const path = require('path');

module.exports = {
  entry: './resources/js/components/Cart.jsx',
  output: {
    path: path.resolve(__dirname, 'public/js'),
    filename: 'Cart.js',
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },
  resolve: {
    extensions: ['.js', '.jsx'],
  },
};
