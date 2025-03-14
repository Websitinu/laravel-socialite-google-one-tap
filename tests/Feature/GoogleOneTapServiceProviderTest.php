<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use LaravelSocialite\GoogleOneTap\LaravelGoogleOneTapServiceProvider;
use PHPUnit\Framework\TestCase;

class GoogleOneTapServiceProviderTest extends TestCase
{
    public function testRedirectReturnsCorrectMessage()
    {
        $request = new Request();
        $provider = new LaravelGoogleOneTapServiceProvider($request, 'client-id', 'client-secret', 'redirect-url');

        $redirectMessage = $provider->redirect();

        $this->assertEquals(
            'Note that no connection has been established between this package with Google One Tap.',
            $redirectMessage
        );
    }
}
