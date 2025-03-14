<?php

namespace Tests\Unit\Exceptions;

use LaravelSocialite\GoogleOneTap\Exceptions\InvalidIdTokenException;
use PHPUnit\Framework\TestCase;

class InvalidIdTokenExceptionTest extends TestCase
{
    public function testExceptionMessage()
    {
        try {
            throw new InvalidIdTokenException();
        } catch (InvalidIdTokenException $e) {
            $this->assertEquals('The provided id_token from Google is invalid or not properly copied.', $e->getMessage());
        }
    }
}
