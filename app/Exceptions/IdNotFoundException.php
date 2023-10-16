<?php

namespace App\Exceptions;

use Exception;

class IdNotFoundException extends Exception
{
    // public function __construct($message, $code = null)
    // {
    //     return parent::__construct($message, $code);
    // }

    public static function notFount($message, $code = null)
    {
        return new static($message, $code);
    }
}
