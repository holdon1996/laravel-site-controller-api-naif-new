<h1>API Site Controller Package for Laravel</h1>

## Introduction
This package is a simple implementation of a Laravel package that helps you create a simple service Site Controller API

## Features
- Include routes for get data
- Include multiple jobs for get data
- Include postman collection for test API

## System Requirements
- Laravel 5.5 or later
- PHP 7.4 or later

## Installation
Install the package via composer:
``` composer require thachvd/laravel-site-controller-api-naif-new```

in Laravel old version maybe you need to add service provider to config/app.php
```
'providers' => [
    ThachVd\LaravelSiteControllerApi\SiteControllerApiServiceProvider::class,
];
```
run command:
```php artisan vendor:publish --provider="ThachVd\LaravelSiteControllerApi\SiteControllerApiServiceProvider" ```

run command:
```php artisan migrate ```

Add env key and value from packages/thachvd/laravel-site-controller-api-naif/src/.env.example to .env

## Testing
You can download postman collection in path ``` thachvd/laravel-site-controller-api-naif/src/postman/Laravel Site Controller API Package.postman_collection.json ``` and run server ``` php artisan serve ``` then test it.

