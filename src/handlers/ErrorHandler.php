<?php

namespace AI\ErrorSDK\handlers;

use ErrorException;
use AI\ErrorSDK\AIError;

require_once __DIR__ . '/../AIError.php';

class ErrorHandler
{
    public static function register()
    {
        set_error_handler(function ($severity, $message, $file, $line) {

            if (!(error_reporting() & $severity)) {
                return false;
            }

            AIError::capture(new ErrorException($message, 0, $severity, $file, $line));
        });

        register_shutdown_function(function () {
            $e = error_get_last();
            if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
                AIError::capture(new ErrorException(
                    $e['message'], 0, $e['type'], $e['file'], $e['line']
                ));
            }
        });
    }
}
