<?php

namespace Tests\Unit;

use LaravelSocialite\GoogleOneTap\GoogleOneTapUser;
use PHPUnit\Framework\TestCase;

class GoogleOneTapUserTest extends TestCase
{
    public function testToArrayReturnsCorrectArray()
    {
        $payload = [
            'sub' => '123456789',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'picture' => 'url-to-avatar',
            'family_name' => 'Doe'
        ];
        $user = new GoogleOneTapUser($payload);
        $userArray = $user->toArray();

        $this->assertArrayHasKey('id', $userArray);
        $this->assertEquals('123456789', $userArray['id']);
    }
}
