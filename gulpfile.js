var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('app.scss');

    mix.scriptsIn('public/js/scripts');
    mix.browserify('app.js');
});
