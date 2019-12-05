<?php

namespace sokolnikov911\LaravelSendy;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/config/laravel-sendy.php';
    const TRANSLATIONS_PATH = __DIR__ . '/resources/lang';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('laravel-sendy.php'),
        ], 'config');

        $this->loadTranslationsFrom(self::TRANSLATIONS_PATH, 'laravel-sendy');

        $this->publishes([
            self::TRANSLATIONS_PATH => resource_path('lang/vendor/laravel-sendy'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'laravel-sendy'
        );

        $this->app->bind('laravel-sendy', function () {
            return new LaravelSendy();
        });
    }
}
