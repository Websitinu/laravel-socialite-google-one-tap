<?php

namespace LaravelSocialite\GoogleOneTap;

use Google\Client;
use Illuminate\Support\Arr;
use LaravelSocialite\GoogleOneTap\InvalidIdToEx;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;


class LaravelGoogleOneTapServiceProvider extends AbstractProvider
{
    public const IDENTIFIER = 'Laravel-GOOGLE-ONE-TAP';

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function redirect()
    {
        return 'Note that no connection has been established between this package with Google One Tap.';
    }



    protected function getUserByToken($token): array
    {

        $this->stateless = true;

        $client = new Client([
            'client_id' => config('services.laravel-google-one-tap.client_id'),
            'client_secret' => config('services.laravel-google-one-tap.client_secret'),
        ]);

        $payload = $client->verifyIdToken($token);

        if (!$payload) {
            throw new InvalidIdToEx();
        }

        return $payload;
    }

    protected function mapUserToObject(array $user): User
    {
        return (new User())->setRaw($user)->map([
            'avatar' => Arr::get($user, 'avatar'),
            'email' => Arr::get($user, 'email'),
            'email_verified' => Arr::get($user, 'email_verified'),
            'host_domain' => Arr::get($user, 'host_domain'),
            'id' => Arr::get($user, 'id'),
            'name' => Arr::get($user, 'name'),
        ]);
    }
    protected function getAuthUrl($state)
    {
        //
    }
    public function refreshToken($refreshToken)
    {
        return 'Note that no connection has been established between this package with Google One Tap.';
    }

    protected function getTokenUrl()
    {
        //
    }
}
