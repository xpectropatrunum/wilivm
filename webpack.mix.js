let mix = require('laravel-mix');

mix.sass('resources/scss/app.scss', 'public/assets/css/main')
mix.sass('resources/scss/pages/auth.scss', 'public/assets/css/pages')
mix.sass('resources/scss/themes/dark/app-dark.scss', 'public/assets/css/main')