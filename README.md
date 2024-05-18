# Laravel Request ID

Request ID is uniquely identifies the HTTP request sent from the app to the service and enables the app to correlate requests and responses, in case the app needs to resend a request because of a dropped connection. This package provides a middleware that allows to generate a unique request id and append on log context every time if the log called.


## Installation

You can install the package via composer:

```bash
composer require alitindrawan24/laravel-request-id
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Alitindrawan24\RequestID\RequestIDServiceProvider" --tag="config" 
```
## Usage

This packages provides a middleware which can be added as a global middleware or as a single route.

```php
// in `app/Http/Kernel.php`

protected $middleware = [
    // ...
    
    \Alitindrawan24\RequestID\Middleware\RequestID::class
];
```

```php
// in a routes file

Route::post('/dashboard', function () {
    //
})->middleware(\Alitindrawan24\RequestID\Middleware\RequestID::class);
```

## Testing

```bash
composer test
```

## License
This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/MarketingPipeline/README-Quotes/blob/main/LICENSE) file for details.

## Contributors
<a href="https://github.com/alitindrawan24/laravel-request-id/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=alitindrawan24/laravel-request-id" />
</a>
