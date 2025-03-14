<?php

namespace LaravelSocialite\GoogleOneTap;

use SocialiteProviders\Manager\SocialiteWasCalled;

class GoogleOneTapSocialiteExtend
{
    public function handle(SocialiteWasCalled $sWasCalled)
    {
        $sWasCalled->extendSocialite('laravel-google-one-tap', LaravelGoogleOneTapServiceProvider::class);
    }
}
