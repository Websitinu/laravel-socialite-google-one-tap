<?php

namespace LaravelSocialite\GoogleOneTap;

use SocialiteProviders\Manager\SocialiteWasCalled;

class LaravelSocialiteGoogleOneTap
{

    public function handle(SocialiteWasCalled $sWasCalled)
    {
        $sWasCalled->extendSocialite('laravel-google-one-tap', LaravelGoogleOneTapServiceProvider::class);
    }
}
