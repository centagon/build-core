const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir(mix => {
    const __root = __dirname + '/../../../../public/vendor/build/core';

    mix
        .sass('core.scss')
        .copy('public/css/core.css', __root + '/css/core.css');

    mix
        .webpack('core.js')
        .copy('public/js/core.js', __root + '/js/core.js');

    mix
        .scripts([
            '../components/jquery/dist/jquery.min.js',
            '../components/select2/dist/js/select2.full.js',
            '../components/spectrum/spectrum.js'
        ], 'public/js/vendor.js')
        .copy('public/js/vendor.js', __root + '/js/vendor.js');
});
