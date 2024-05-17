<?php

namespace laravelSocialite\GoogleOneTap;

use Exception;

class InvalidIdToEx extends Exception
{
    protected $message = 'The provided id_token taken from Google is not copied correctly and is not valid';
}
