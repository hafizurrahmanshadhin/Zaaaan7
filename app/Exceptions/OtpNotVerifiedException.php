<?php

namespace App\Exceptions;

use Exception;

class OtpNotVerifiedException extends Exception
{
    protected $message = 'otp not verified';
    protected $code = 404; // HTTP status code
}
