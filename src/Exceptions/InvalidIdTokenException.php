<?php

namespace LaravelSocialite\GoogleOneTap\Exceptions;

use Exception;

class InvalidIdTokenException extends Exception
{
    protected $message = 'The provided id_token from Google is invalid or not properly copied.';
}
