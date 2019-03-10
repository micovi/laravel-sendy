# Laravel Sendy

[![Build Status](https://travis-ci.org/micovi/laravel-sendy.svg?branch=master)](https://travis-ci.org/micovi/laravel-sendy)
[![Packagist](https://img.shields.io/packagist/v/micovi/laravel-sendy.svg)](https://packagist.org/packages/micovi/laravel-sendy)
[![Packagist](https://poser.pugx.org/micovi/laravel-sendy/d/total.svg)](https://packagist.org/packages/micovi/laravel-sendy)
[![Packagist](https://img.shields.io/packagist/l/micovi/laravel-sendy.svg)](https://packagist.org/packages/micovi/laravel-sendy)

Package description: CHANGE ME

## Installation

Install via composer
```bash
composer require micovi/laravel-sendy
```

### Register Service Provider

**Note! This step is optional if you use laravel >= 5.5
with package auto discovery feature.**

Add service provider to `config/app.php` in `providers` section
```php
Micovi\LaravelSendy\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section
```php
Micovi\LaravelSendy\Facades\LaravelSendy::class,
```

### Publish Configuration File

```bash
php artisan vendor:publish --provider="Micovi\LaravelSendy\ServiceProvider" --tag="config"
```

## Usage

CHANGE ME

## Security

If you discover any security related issues, please email
instead of using the issue tracker.

## Credits

- [All contributors](https://github.com/micovi/laravel-sendy/graphs/contributors)
