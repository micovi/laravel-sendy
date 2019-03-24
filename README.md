# Laravel Sendy

[![Build Status](https://travis-ci.org/micovi/laravel-sendy.svg?branch=master)](https://travis-ci.org/micovi/laravel-sendy)
[![Packagist](https://img.shields.io/packagist/v/micovi/laravel-sendy.svg)](https://packagist.org/packages/micovi/laravel-sendy)
[![Packagist](https://poser.pugx.org/micovi/laravel-sendy/d/total.svg)](https://packagist.org/packages/micovi/laravel-sendy)
[![Packagist](https://img.shields.io/packagist/l/micovi/laravel-sendy.svg)](https://packagist.org/packages/micovi/laravel-sendy)

Package description: Laravel simple integration with Sendy API to subscribe/unsubscribe users to list.

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
'LaravelSendy' => Micovi\LaravelSendy\Facades\LaravelSendy::class,
```

### Add env variables

```env
SENDY_API_KEY=your-api-key
SENDY_URL=your-sendy-url
SENDY_LIST_ID=your-list-id
```

LIST ID can be found encrypted & hashed in View all lists section under the column named ID

## Customizing or extending

### Publish configuration file

You can publish configuration file to edit the variables, in case you don't want to use ENV. File will pe published in `/config/larave-sendy.php`

```bash
php artisan vendor:publish --provider="Micovi\LaravelSendy\ServiceProvider" --tag="config"
```

### Publish translations

You can publish translations to edit them. Files will be published in `/resources/lang/vendor/laravel-sendy`.

**Note:** You can extend translations by creating a new file in `/resources/lang/vendor/laravel-sendy/{lang}/messages.php` using the format from `en` language file.

## Usage examples

Before any usage add Namespace to file.

```php
use Micovi\LaravelSendy\LaravelSendy;
```

### Subscribe
Subscribes a new email to list. This can be used to edit already subscribed users. (eg. change name)

```php
// initialize LaravelSendy
$sendy = new LaravelSendy();

// Simple email subscribe
$subscribe = $sendy->subscribe('email@example.com');

// Add subscriber with email and name
$subscribe = $sendy->subscribe('email@example.com', 'John Doe');

// Full subscribe method
$subscribe = $sendy->subscribe($email, $name = null, $listId = null, $json = false, $customFields = []);

// Response example
$subscribe = [
  "success" => true
  "message" => "You have been subscribed."
]
```

### Unsubscribe Examples
Marks email as unsubscribed from the list.
```php
// initialize LaravelSendy
$sendy = new LaravelSendy();

// Simple unsubscribe
$unsubscribe = $sendy->unsubscribe('email@example.com');

// Full unsubscribe method
$unsubscribe = $sendy->unsubscribe($email, $listId = null, $json = false);

// Response example
$unsubscribe = [
  "success" => true
  "message" => "You have been unsubscribed."
]
```

### Delete Example
Deletes email from list. Action is definitive.

```php
// initialize LaravelSendy
$sendy = new LaravelSendy();

// Simple delete
$delete = $sendy->delete('email@example.com');

// Full unsubscribe method
$delete = $sendy->delete($email, $listId = null, $json = false);

// Response example
$delete = [
  "success" => true
  "message" => "You have been deleted from the list."
]
```

## Security

If you discover any security related issues, please email
instead of using the issue tracker.

## Contribute

If you wish to contribute to translations for the package in your language you can submit a PR request with the lang files copied from en `resources/lang/en/messages.php`.
