var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

elixir(function(mix) {
	mix.sass('resources/assets/sass/styles/main.scss', 'public/css');
	mix.scripts(
        'resources/assets/js/main.js',
        'public/js'
    );
	mix.browserSync({
		proxy: 'localhost:8000'
	});
});