<?php

namespace Tests\Feature;

use LaravelSocialite\GoogleOneTap\GoogleOneTapSocialiteExtend;
use LaravelSocialite\GoogleOneTap\LaravelGoogleOneTapServiceProvider;
use PHPUnit\Framework\TestCase;
use SocialiteProviders\Manager\SocialiteWasCalled;

class GoogleOneTapSocialiteExtendTest extends TestCase
{
    public function testHandleExtendsSocialite()
    {
        $socialiteWasCalled = $this->createMock(SocialiteWasCalled::class);
        $socialiteWasCalled->expects($this->once())
            ->method('extendSocialite')
            ->with('laravel-google-one-tap', LaravelGoogleOneTapServiceProvider::class);

        $extend = new GoogleOneTapSocialiteExtend();
        $extend->handle($socialiteWasCalled);
    }
}
