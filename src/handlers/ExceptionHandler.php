<?php

namespace AI\ErrorSDK\handlers;

use Throwable;
use AI\ErrorSDK\AIError;

require_once __DIR__ . '/../AIError.php';

class ExceptionHandler
{
    public static function register()
    {
        set_exception_handler(function (Throwable $e) {
            AIError::capture($e);
        });
    }
}
