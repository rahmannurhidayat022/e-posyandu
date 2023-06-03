let mix = require("laravel-mix");

mix.autoload({
    jquery: ["$", "jQuery", "window.jQuery"],
});

mix.webpackConfig({
    stats: {
        children: true,
    },
})
    .sass("resources/css/app.scss", "public/assets/css/")
    .js("resources/js/app.js", "public/assets/js/")
    .copy("resources/images", "public/assets/images/");
