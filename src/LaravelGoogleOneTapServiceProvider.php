<?php

namespace LaravelSocialite\GoogleOneTap;

use LaravelSocialite\GoogleOneTap\Exceptions\InvalidIdTokenException;
use LaravelSocialite\GoogleOneTap\Services\GoogleOneTapClient;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;

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
}
