let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
  .sass('resources/css/style.scss', 'public/css')
  mix.autoload({
    jquery: ['$', 'window.jQuery']
	})
  .sourceMaps()
  .version();
