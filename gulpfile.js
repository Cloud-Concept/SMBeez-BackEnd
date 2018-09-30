var elixir = require('laravel-elixir');

elixir.config.sourcemaps = true;

elixir(function(mix) {
	mix.sass('resources/assets/sass/styles/main.scss', 'public/css');
	mix.scripts(
        'resources/assets/js/main.js',
        'public/js'
    );
	mix.browserSync({
    // change by ur localhost address
		proxy: 'http://smbeez.local'
	});
});



// Run all tasks...
//gulp

// Run all tasks and minify all CSS and JavaScript...
//gulp --production


//watch files
//gulp watch
