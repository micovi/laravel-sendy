<?php

namespace Micovi\LaravelSendy;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/laravel-sendy.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('laravel-sendy.php'),
        ], 'config');
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
