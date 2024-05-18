<p align="center"><a href="https://websitinu.com" target="_blank"><img src="https://raw.githubusercontent.com/Websitinu/laravel-socialite-google-one-tap/main/img/Websitinu-laravel-socialite-google-one-tap.png" width="1200"></a></p>

# Light Package To Install Google One Tap provider for Laravel Socialite

<p align="center">
<a href="https://github.com/Websitinu/laravel-socialite-google-one-tap"><img src="https://raw.githubusercontent.com/websitinu/laravel-socialite-google-one-tap/main/img/test/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/dt/websitinu/laravel-socialite-google-one-tap" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/v/websitinu/laravel-socialite-google-one-tap" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/l/websitinu/laravel-socialite-google-one-tap" alt="License"></a>
</p>

## Installation

```bash
composer require websitinu/laravel-socialite-google-one-tap
```

Usage

```dotenv
# .env

GOOGLE_CLIENT_ID_ONE_TAP=176204740264-36ufetlsp0u32ont3ag091fsf5ssmfq2q5.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET_ONE_TAP=GOCSPuX-4-h099j3hOKcAWmCsE0kgyvdg5nU
GOOGLE_LOGIN_URI_ONE_TAP=/google-one-tap
```

```php
# config/services.php

return [

    // other providers

    'laravel-google-one-tap' => [
      'client_id' => env('GOOGLE_CLIENT_ID_ONE_TAP'),
      'client_secret' => env('GOOGLE_CLIENT_SECRET_ONE_TAP'),
      'redirect' => env('GOOGLE_LOGIN_URI_ONE_TAP'),
    ],
];
```

<h3 id="for-example-in-laravel-11"><a href="#for-example-in-laravel-11" class="header-anchor">#</a> For example in Laravel 11+</h3>
<p>In <code>app/providers/AppServiceProvider.php</code>.</p>

```php
namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use LaravelSocialite\GoogleOneTap\LaravelGoogleOneTapServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('laravel-google-one-tap', LaravelGoogleOneTapServiceProvider::class);
        });
    }
}

```

<h3 id="for-example-in-laravel-10-or-below"><a href="#for-example-in-laravel-10-or-below" class="header-anchor">#</a> For example in Laravel 10 or below</h3>
<p>In <code>app/providers/AppServiceProvider.php</code>.</p>

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelSocialite\GoogleOneTap\LaravelGoogleOneTapServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // other providers
            LaravelGoogleOneTapServiceProvider::class,
        ],
    ];
}
```
