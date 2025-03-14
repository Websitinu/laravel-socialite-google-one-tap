<p align="center"><a href="https://websitinu.com" target="_blank"><img src="https://raw.githubusercontent.com/Websitinu/laravel-socialite-google-one-tap/main/img/Websitinu-laravel-socialite-google-one-tap.png" width="1200"></a></p>

# A lightweight package to integrate Google One Tap with Laravel Socialite.

<p align="center">
<a href="https://github.com/Websitinu/laravel-socialite-google-one-tap"><img src="https://raw.githubusercontent.com/websitinu/laravel-socialite-google-one-tap/main/img/test/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/dt/websitinu/laravel-socialite-google-one-tap" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/v/websitinu/laravel-socialite-google-one-tap" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/websitinu/laravel-socialite-google-one-tap"><img src="https://img.shields.io/packagist/l/websitinu/laravel-socialite-google-one-tap" alt="License"></a>
</p>

## Installation
To install this package, run the following composer command:

```bash
composer require websitinu/laravel-socialite-google-one-tap
```


## Configuration
### Step 1: Create a Google Project
1.Go to the  [Google Cloud console](https://console.cloud.google.com/apis/credentials/consent).

2.If you haven't already, create a new project by clicking on Select a Project in the top header and then New Project. Follow the steps to create a project.

3.Once your project is created, you'll need to set up OAuth consent screen and OAuth 2.0 credentials.

### For Use Google One Tap

1. **Set up Google OAuth credentials:**
   - In your **Google Cloud Console**, go to the **Credentials** tab on the left sidebar.
   - Click on **Create Credentials** and choose **OAuth Client ID**.
   
   1.1 **Configure the OAuth consent screen:**
   - Fill out the necessary fields like **App name**, **User support email**, etc.
   - For **Scopes**, you can keep the default or add specific scopes if needed.
   
   1.2 **Under Application type**, select **Web application**.
   
   1.3 **In the Authorized JavaScript origins**, add the URLs where your app will be hosted (e.g., `http://localhost` for local development).
   
### Authorized JavaScript origins exampls for local development 

For use with requests from a browser on local host 

```bash

URIs 1 
http://localhost:8000
URIs 2 
http://localhost
URIs 3 
https://localhost:8000
URIs 4 
https://localhost
URIs 5 
http://127.0.0.1:8000
URIs 6 
https://127.0.0.1:8000
URIs 7 
http://127.0.0.1
URIs 8 
https://127.0.0.1

```
### you can reaplace it just with your real domain .
   
   1.4 **In the Authorized redirect URIs**, add the URL that your app will redirect to after the user logs in. For example, `/google-one-tap` (this is set in your `.env` file).

### Authorized redirect URIs

For use with requests from a web server

```bash
URIs 1 
http://127.0.0.1:8000/auth/google/onetap
URIs 2 
http://localhost:8000/auth/google/onetap
URIs 3 
https://127.0.0.1:8000/auth/google/onetap
URIs 4 
https://localhost:8000/auth/google/onetap
```
#### or you can reaplace with your own route address

3. **Get the credentials:**
   After configuring OAuth credentials, you will receive a **Client ID** and **Client Secret**. Add these credentials to your `.env` file as follows:

   ```dotenv
   # .env
   GOOGLE_ONE_TAP_CLIENT_ID=YOUR_GOOGLE_CLIENT_ID
   GOOGLE_ONE_TAP_CLIENT_SECRET=YOUR_GOOGLE_CLIENT_SECRET
   GOOGLE_ONE_TAP_LOGIN_URI=http://localhost:8000/auth/google/onetap
   ```

### For Users Who Want to Use Google One Tap with Regular Google Login

If you want to integrate **Google One Tap** alongside the traditional **Google login**, you'll need to follow these additional steps:

1. **Set up Google OAuth credentials for regular Google login:**
   - In the same **Credentials** tab, create another **OAuth Client ID** for regular Google login:
   
   1.1 **Configure the OAuth consent screen:**
   - Fill out the necessary fields like **App name**, **User support email**, etc.
   - For **Scopes**, you can keep the default or add specific scopes if needed.
   
   1.2 **Under Application type**, select **Web application**.
   
   1.3 **In the Authorized JavaScript origins**, nothing to add and leave empty.
   
   1.4 **In the Authorized redirect URIs**, Follow the same steps as for Google One Tap but configure the **Authorized redirect URIs** differently. For Google login, this URI is typically something like `http://localhost:8000/auth/google/callback`

### Authorized redirect URIs

For use with requests from a web server

```bash
URIs 1 
http://127.0.0.1:8000/auth/google/callback
URIs 2 
http://localhost:8000/auth/google/callback
URIs 3 
https://127.0.0.1:8000/auth/google/callback
URIs 4 
https://localhost:8000/auth/google/callback
```
#### you can reaplace with your own route address

3.  **Add credentials to `.env` file:**
   In addition to the credentials for **Google One Tap**, add the credentials for the **regular Google login**:


   ```dotenv
   # .env
   
   # Google One Tap credentials
   GOOGLE_ONE_TAP_CLIENT_ID=YOUR_GOOGLE_CLIENT_ID_ONE_TAP
   GOOGLE_ONE_TAP_CLIENT_SECRET=YOUR_GOOGLE_CLIENT_SECRET_ONE_TAP
   GOOGLE_ONE_TAP_LOGIN_URI=http://localhost:8000/auth/google/onetap

   # Regular Google login credentials
   GOOGLE_CLIENT_ID=YOUR_GOOGLE_CLIENT_ID
   GOOGLE_CLIENT_SECRET=YOUR_GOOGLE_CLIENT_SECRET
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

   ```



```php
# config/services.php

return [

    'laravel-google-one-tap' => [
        'client_id' => env('GOOGLE_ONE_TAP_CLIENT_ID'),
        'client_secret' => env('GOOGLE_ONE_TAP_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_ONE_TAP_REDIRECT_URL'),
    ],

    // other providers

   'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT_URI'),
    ],
];
```

### Add provider event listener

Configure the package's listener to listen for `SocialiteWasCalled` events. Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.

<h3 id="for-example-in-laravel-11"><a href="#for-example-in-laravel-11" class="header-anchor">#</a> For example in Laravel 11 and 12</h3>
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

On any page where you wish to use Google One Tap, you need to add the following script to the header of your HTML templates.


```html
@guest
<script src="https://accounts.google.com/gsi/client" async defer></script>
@endguest
```
The Google One Tap prompt itself can be triggered using either JavaScript or HTML. The following code processes the response server-side in HTML. It doesn't matter where you place this code, and you can also append `data-client_id` and `data-login_uri` to any existing HTML element. For more settings and variations, such as a complete JavaScript implementation, check the [references](#references).


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
Styling this element won't affect the appearance, as Google One Tap is transitioning to [FedCM](https://developer.chrome.com/en/docs/privacy-sandbox/fedcm/), meaning the prompt will be handled by the browser if it supports it.

To sign out, add a `g_id_signout` class to your sign-out button to prevent a redirection loop due to `data-auto_select` in the previous code.


```html
<form action="{{ route('logout') }}" method="post">
  @csrf
  <button class="g_id_signout">Sign out</button>
</form>
```
Google One Tap has a cooldown period after a user dismisses the prompt. The more frequently a user closes the prompt, the longer it will take for the prompt to reappear. Therefore, include a sign-in button as a fallback to trigger the Google Sign-In prompt. Typically, you'll want to add this button on login and registration pages. The [Only](https://developers.google.com/identity/gsi/web/reference/html-reference#button-attribute-types) required field is `data-type`.

```html
<div class="g_id_signin" data-type="standard"></div>
```

### Back-end




```php
// routes/web.php


#if you want use only google one tap


use App\Controllers\GoogleOneTapController;
use Illuminate\Support\Facades\Route;

Route::post('auth/google/onetap', [GoogleOneTapController::class, 'handler'])
    ->middleware('guest')
    ->name('google-one-tap.handler');

----------------- or ------------------
#if you want use with any provider


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::get('{provider}', 'redirectToProvider')->name('provider.auth');
    Route::get('{provider}/callback', 'callbackToProvider');
    Route::post('google/onetap', 'googleOneTap')->middleware('guest')->name('google-one-tap.handler');
});

```
Google One Tap is built on top of OAuth, but it operates differently by using an authenticating JWT token instead of access and refresh tokens. The redirect() and refreshToken() methods will not be utilized in this context and will throw an Error as a reminder.

Your controller will not need to redirect the user, and instead of resolving the user, you can immediately resolve the token.

```php
use Laravel\Socialite\Facades\Socialite;

return Socialite::driver('laravel-google-one-tap')->userFromToken($token);
```

This function will either return the decoded payload of the JWT token or throw an `Error` if the token provided is invalid.  

#### Payload Structure  

| Field          | Type    | Description                                      |
| -------------- | ------- | ------------------------------------------------ |
| id             | string  | Unique identifier for the user from Google       |
| name           | string  | Full name of the user                            |
| email          | string  | User’s email address                             |
| avatar         | ?string | Profile picture of the user (if available)       |
| nick name      | string  | User’s family name (if provided)                 |
| email_verified | boolean | Indicates whether Google has verified the email  |

#### Handling the Payload  

Once you retrieve the payload, which includes the user's `email`, you can determine the next steps in the authentication process. If the email is already in your database, proceed with logging the user in. Otherwise, you may need to register a new user using the provided details.




```php
// GoogleOneTapController.php

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use LaravelSocialite\GoogleOneTap\InvalidIdToEx;

public function handler(Request $request)
{
    // Verify and validate JWT received from Google One Tap prompt
    try {
        $googleUser = Socialite::driver('laravel-google-one-tap')->userFromToken($request->input('credential'));
    } catch (InvalidIdToEx $exception) {
        return response()->json(['error' => $exception]);
    }

    // Log the user in if the email is associated with a user

    try {
        $googleUser = User::where('email', $googleUser['email'])->firstOrfail();
    } catch (\Exception $ex) {

        $user = User::create([
                'name' => $googleUser->getName(),
                'lastName' => $googleUser->getNickName(),
                'provider_name' => 'google-one-tap',
                'email' => $googleUser->getEmail(),
                'password' => Hash::make($googleUser->getId()),
                'email_verified_at' =>  $googleUser->user['email_verified'] ? now() : null,
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

# OR if you want use with any provider
```php
// AuthController.php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\UserProviderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callbackToProvider($provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $ex) {
            Log::error("Social login error: " . $ex->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred while logging in.');
        }
    
        // Check if the user already exists
        $user = User::where('email', $socialiteUser->getEmail())->first();
    
        if (!$user) {
            // Create a new user only if they don't exist
            $user = User::create([
                'name' => $socialiteUser->getName(),
                'provider_name' => $provider,
                'email' => $socialiteUser->getEmail(),
                'password' => Hash::make($socialiteUser->getId()), // Not used but required
                'email_verified_at' => now(),
                'profile_photo_path' => $socialiteUser->getAvatar(),
            ]);
    
        }
    
        // Log the user in without updating their data
        Auth::login($user, true);
    
        return redirect()->route('home');
    }
    

    public function googleOneTap(Request $request)
    {
        try {
            $googleUser = Socialite::driver('laravel-google-one-tap')->userFromToken($request->input('credential'));
        } catch (\Exception $exception) {
            Log::error("Google One Tap Login Failed: " . $exception->getMessage());
            return response()->json(['error' => 'Google authentication failed'], 400);
        }
    
        // Find existing user or create a new one
        $user = User::firstOrNew(['email' => $googleUser->getEmail()]);
    
        if (!$user->exists) {
            $user->name = $googleUser->getName();
            $user->provider_name = 'google';
            $user->password = Hash::make($googleUser->getId()); // Not used, but required
            $user->email_verified_at = now();
            $user->profile_photo_path = $googleUser->getAvatar();
            $user->save(); // Store user data before using user_id
        }
    
        // Ensure user_id exists
        if (!$user->id) {
            Log::error("Google One Tap Error: user_id is null for email: " . ($googleUser->getEmail() ?? 'unknown'));
            return response()->json(['error' => 'User not found or not created'], 400);
        }
    
    
        // Log in the user
        Auth::login($user, true);
    
        return redirect()->route('home');
    }
    
    
}

```



## References

- [Google Identity Services Overview](https://developers.google.com/identity/gsi/web/guides/overview)
- [Google Identity HTML Reference](https://developers.google.com/identity/gsi/web/reference/html-reference)
- [Google Identity JavaScript Reference](https://developers.google.com/identity/gsi/web/reference/js-reference)
- [Google API PHP Client](https://github.com/googleapis/google-api-php-client)
- [Google API PHP Client Docs](https://googleapis.github.io/google-api-php-client/main/)
- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
- [Google OAuth 2.0 for Web](https://developers.google.com/identity/protocols/oauth2/web-server)

## License

This package is licensed under the MIT License (MIT). See the [LICENSE](LICENSE.md) for more details.
