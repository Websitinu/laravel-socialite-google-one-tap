<p align="center"><a href="https://websitinu.com" target="_blank"><img src="https://raw.githubusercontent.com/Websitinu/laravel-socialite-google-one-tap/main/img/Websitinu-laravel-socialite-google-one-tap.png" width="1200"></a></p>

# Light Package To Install Google One Tap provider for Laravel Socialite

<p align="center">
<a href="https://github.com/Websitinu/laravel-socialite-google-one-tap"><img src="https://raw.githubusercontent.com/websitinu/laravel-socialite-google-one-tap/main/img/test/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/dt/websitinu/laravel-socialite-google-one-tap" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/v/websitinu/laravel-socialite-google-one-tap" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/l/websitinu/laravel-socialite-google-one-tap" alt="License"></a>
</p>

## Installation Laravel Socialite Google One Tap

```bash
composer require websitinu/laravel-socialite-google-one-tap
```


## Installation socialite

In addition to typical, form based authentication, Laravel also provides a simple, convenient way to authenticate with OAuth providers using Laravel Socialite.

<p>In addition to typical, form based authentication, Laravel also provides a simple, convenient way to authenticate with OAuth providers using <a href="https://laravel.com/docs/11.x/socialite#installation
">Laravel Socialite</a>.

```bash
composer require laravel/socialite
```


## Usage

### Setup Google project

First you might need to create a new project at [Google Cloud console](https://console.cloud.google.com/apis/credentials/consent), set up the _OAuth consent screen_ and create a new _OAuth Client ID_. Within the Credentials menu you will find the client ID and client secret which you will need for authenticating.

### Add configuration

You will need to store the client ID and client secret in your `.env` file and add the configuration to `config/services.php`. You will also need to add a redirection url which will be used for logging in and registering with Google One Tap. This package refers to a specific .env value for Google One Tap to avoid any clashes with the standard Google Socialite provider.

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

### Add provider event listener

Configure the package's listener to listen for `SocialiteWasCalled` events. Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.

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

## Usage front-end

Google One Tap requires a specific implementation both in the front-end as the back-end.

### Front-end

On every page where you want to use Google One Tap, you will need to include the following script in the header of your html templates.
++

```html
@guest
<script src="https://accounts.google.com/gsi/client" async defer></script>
@endguest
```

The actual Google One Tap prompt can be initiated with either javascript or html. The following code handles the response server side in html. It does not matter where you place this code. You can also append `data-client_id` and `data-login_uri` to any existing html element. Check [references](#references) for more settings and variations such as a full javascript implementation.

```html
@guest
<div
  id="g_id_onload"
  data-auto_select="true"
  data-client_id="{{ config('services.laravel-google-one-tap.client_id') }}"
  data-login_uri="{{ config('services.laravel-google-one-tap.redirect') }}"
  data-use_fedcm_for_prompt="true"
  data-_token="{{ csrf_token() }}"
></div>
@endguest
```

And Styling this element won't have any effect since Google One tap is migrating to [FedCM](https://developer.chrome.com/en/docs/privacy-sandbox/fedcm/) which means the prompt will be handled by the browser itself if the browser supports it.

For signing out you should add a `g_id_signout` class to your sign-out button to avoid a redirection loop because of `data-auto_select` in the previous snippet.

```html
<form action="{{ route('logout') }}" method="post">
  @csrf
  <button class="g_id_signout">Sign out</button>
</form>
```

Google One Tap has a cooldown period when a user closes the Google One Tap prompt. The more often a user closes the prompt, the longer it will take for the prompt to be able to reappear to the user. Therefore, you need to include a sign-in button for a fallback to a Google Sign-In prompt. You will likely only want to include this button on login and register pages. [Only](https://developers.google.com/identity/gsi/web/reference/html-reference#button-attribute-types) the data-type field is required.

```html
<div class="g_id_signin" data-type="standard"></div>
```

### Back-end

Google One Tap is build on top of OAuth, but works different with an authenticating JTW token instead of with access tokens and refresh tokens. The `redirect()` and `refreshToken()` method won't be used in this context and will throw a `Error` as a reminder.

Your controller won't need to redirect the user and instead of resolving the user, you can immediately resolve the token.

```php
use Laravel\Socialite\Facades\Socialite;

return Socialite::driver('laravel-google-one-tap')->userFromToken($token);
```

This method will return the payload of the JWT token or throw an `Error` if the provided token was invalid.

#### Payload array

| Field          | Type    | Description                                                   |
| -------------- | ------- | ------------------------------------------------------------- |
| avatar         | ?string | The user's profile picture if present                         |
| email          | string  | The user's email address                                      |
| email_verified | boolean | True, if Google has verified the email address                |
| id             | string  | The user's unique Google ID                                   |
| name           | string  | The user's name                                               |




#### connect the payload

With the payload containing the `email` you can now handle the user flow after the user finished interacting with the Google One Tap prompt. This usually involves either registering the user if the Email isn't present in your database or logging in the user if you have a user registered with this Email.


```php
// routes/web.php

use App\Controllers\GoogleOneTapController;
use Illuminate\Support\Facades\Route;

Route::post('google-one-tap', [GoogleOneTapController::class, 'connect'])
    ->middleware('guest')
    ->name('google-one-tap.Connect');
```

```php
// GoogleOneTapController.php

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use LaravelSocialite\GoogleOneTap\InvalidIdToEx;

public function connect(Request $request)
{
    // Verify and validate JWT received from Google One Tap prompt
    try {
        $googleUser = Socialite::driver('laravel-google-one-tap')->userFromToken($request->input('credential'));
    } catch (InvalidIdToEx $exception) {
        return response()->json(['error' => $exception])
    }

    // Log the user in if the email is associated with a user

    try {
        $googleUser = User::where('email', $googleUser['email'])->firstOrfail();
    } catch (\Exception $ex) {
       
        $user = User::create([
            'name' => $googleUser->getName(),
            'provider_name' => 'google-one-tap',
            'email' => $googleUser->getEmail(),
            'password' => Hash::make($googleUser->getId()),
            'email_verified_at' =>  now(),
            'profile_photo_path' => $googleUser->getAvatar()
        ]);

        Auth::login($user, $remember = true);
        return redirect()->route('home');
    }

    Auth::login($googleUser, $remember = true);
    // Send user to Home
    return redirect()->route('home');


}
```

## References

- https://developers.google.com/identity/gsi/web/guides/overview
- https://developers.google.com/identity/gsi/web/reference/html-reference
- https://developers.google.com/identity/gsi/web/reference/js-reference
- https://github.com/googleapis/google-api-php-client
- https://googleapis.github.io/google-api-php-client/main/

## License

This package is licensed under the MIT License (MIT). See the [LICENSE](LICENSE.md) for more details.
