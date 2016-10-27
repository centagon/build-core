const elixir = require('laravel-elixir');

elixir.config.assetsPath = 'src';
elixir.config.publicPath = 'dist';

elixir(mix => {
    mix.sass('primer.scss');
    mix.browserify('primer.js');
});
