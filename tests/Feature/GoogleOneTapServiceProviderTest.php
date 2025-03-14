<?php

namespace Tests\Feature;

use LaravelSocialite\GoogleOneTap\LaravelGoogleOneTapServiceProvider;
use PHPUnit\Framework\TestCase;

class GoogleOneTapServiceProviderTest extends TestCase
{
    public function testRedirectReturnsCorrectMessage()
    {
        $provider = new LaravelGoogleOneTapServiceProvider(app());
        $redirectMessage = $provider->redirect();

        $this->assertEquals('Note that no connection has been established between this package with Google One Tap.', $redirectMessage);
    }
}
