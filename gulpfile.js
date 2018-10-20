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
		proxy: 'http://localhost:8000'
	});
});



// Run all tasks...
//gulp

// Run all tasks and minify all CSS and JavaScript...
//gulp --production


//watch files
<<<<<<< HEAD
//gulp watch
=======
//gulp watch
>>>>>>> 9243dc90590665c2629a08161a332ebe67403706
