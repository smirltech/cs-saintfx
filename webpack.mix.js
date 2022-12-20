const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}

mix.browserSync({
    proxy: 'http://cenk.test',
    injectChanges: false,
});



