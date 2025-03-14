<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // این متد را برای تغییرات اولیه قبل از هر تست اضافه می‌کنیم.
    public function setUp(): void
    {
        parent::setUp();

        // اطمینان از اینکه کانفیگ‌ها به درستی بارگذاری می‌شوند
        Artisan::call('config:clear');
    }
}

