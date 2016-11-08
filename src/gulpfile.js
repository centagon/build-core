const elixir = require('laravel-elixir');

elixir(mix => {
    const __root = __dirname + '/../../../../public/vendor/build/core';

    Elixir.config.css.autoprefix.options.browsers = ['> 25%'];

    mix
        .sass('core.scss')
        .copy('public/css/core.css', __root + '/css/core.css');

    mix
        .webpack('core.js')
        .copy('public/js/core.js', __root + '/js/core.js');

    mix
        .scripts(['../components/jquery/dist/jquery.min.js'], 'public/js/vendor.js')
        .copy('public/js/vendor.js', __root + '/js/vendor.js');
});
