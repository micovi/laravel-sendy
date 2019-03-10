<?php

namespace Micovi\LaravelSendy\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelSendy extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-sendy';
    }
}
