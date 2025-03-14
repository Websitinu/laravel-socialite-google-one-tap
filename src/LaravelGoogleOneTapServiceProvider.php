<?php

namespace LaravelSocialite\GoogleOneTap;

use LaravelSocialite\GoogleOneTap\Exceptions\InvalidIdTokenException;
use LaravelSocialite\GoogleOneTap\Services\GoogleOneTapClient;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

class LaravelGoogleOneTapServiceProvider extends AbstractProvider
{
    public const IDENTIFIER = 'Laravel-GOOGLE-ONE-TAP';

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }

    public function redirect()
    {
        return 'Note that no connection has been established between this package with Google One Tap.';
    }

    protected function getUserByToken($token)
    {
        $this->stateless = true;

        $client = new GoogleOneTapClient();

        $payload = $client->verifyToken($token);

        if (!$payload) {
            throw new InvalidIdTokenException();
        }

        return (new GoogleOneTapUser($payload))->toArray();
    }

    /**
     * Get the authentication URL for Google One Tap.
     */
    protected function getAuthUrl($state)
    {
        return 'https://accounts.google.com/o/oauth2/auth';
    }

    /**
     * Get the token URL for Google One Tap.
     */
    protected function getTokenUrl()
    {
        return 'https://oauth2.googleapis.com/token';
    }

    /**
     * Map the user object from Google to a Socialite user.
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['sub'] ?? null,
            'nickname' => $user['family_name'] ?? null,
            'name'     => $user['name'] ?? null,
            'email'    => $user['email'] ?? null,
            'avatar'   => $user['picture'] ?? null,
        ]);
    }
}
