<?php

namespace Tests\Unit\Services;

use LaravelSocialite\GoogleOneTap\Services\GoogleOneTapClient;
use PHPUnit\Framework\TestCase;
use Google_Client;

class GoogleOneTapClientTest extends TestCase
{
    public function testClientInitialization()
    {
        $client = new GoogleOneTapClient();
        $this->assertInstanceOf(Google_Client::class, $client->client);
    }

    public function testVerifyTokenReturnsNullForInvalidToken()
    {
        $client = new GoogleOneTapClient();
        $result = $client->verifyToken('invalid-token');
        $this->assertNull($result);
    }
}
