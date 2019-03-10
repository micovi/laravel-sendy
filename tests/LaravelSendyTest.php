<?php

namespace Micovi\LaravelSendy\Tests;

use Micovi\LaravelSendy\Facades\LaravelSendy;
use Micovi\LaravelSendy\ServiceProvider;
use Orchestra\Testbench\TestCase;

class LaravelSendyTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'laravel-sendy' => LaravelSendy::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
