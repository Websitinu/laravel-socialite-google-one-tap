<?php

namespace LaravelSocialite\GoogleOneTap\Services;

use Google\Client;

class GoogleOneTapClient
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'client_id' => config('services.laravel-google-one-tap.client_id'),
            'client_secret' => config('services.laravel-google-one-tap.client_secret'),
        ]);
    }

    public function verifyToken(string $token): ?array
    {
        return $this->client->verifyIdToken($token) ?: null;
    }
}
