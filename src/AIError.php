<?php

namespace AI\ErrorSDK;

use Throwable;
use AI\ErrorSDK\models\ErrorPayload;
use AI\ErrorSDK\handlers\ExceptionHandler;
use AI\ErrorSDK\handlers\ErrorHandler;

require_once __DIR__ . '/Transport.php';
require_once __DIR__ . '/AIConfig.php';
require_once __DIR__ . '/models/ErrorPayload.php';
require_once __DIR__ . '/handlers/ExceptionHandler.php';
require_once __DIR__ . '/handlers/ErrorHandler.php';

class AIError
{
    /** @var bool */
    private static $initialized = false;

    /** @var AIConfig */
    private static $config;

    /** @var Transport */
    private static $transport;

    /**
     * Initialize the AI Error SDK.
     *
     * This method must be called once at application bootstrap.
     *
     * @param array{
     *     projectKey?: string,
     *     env?: string,
     *     apiUrl?: string,
     *     debug?: bool
     * } $config Configuration array:
     *
     * - projectKey: Required. Your AI Error project key (string)
     * - env: The environment name ("dev", "prod")
     * - apiUrl: Required. The API endpoint to send error logs to.
     * - debug: Enable SDK debug logging (true/false)
     *
     * @return void
     */
    public static function init(array $config)
    {
        if (self::$initialized) {
            return;
        }

        self::$config = new AIConfig(
            $config['projectKey'] ?? '',
            $config['env'] ?? '',
            $config['apiUrl'] ?? '',
            $config['debug'] ?? false
        );

        self::$transport = new Transport(self::$config);

        ExceptionHandler::register();
        ErrorHandler::register();

        self::$initialized = true;
    }

    public static function capture(Throwable $e)
    {
        if (!self::$initialized) return;

        $payload = new ErrorPayload();
        $payload->env       = self::$config->env;
        $payload->message   = $e->getMessage();
        $payload->type      = get_class($e);
        $payload->file      = $e->getFile();
        $payload->line      = $e->getLine();
        $payload->stack     = $e->getTraceAsString();
        $payload->timestamp = gmdate('Y-m-d\TH:i:s\Z');

        self::$transport->send($payload);

        if (self::$config->debug) {
            error_log("[AI-ERROR-SDK DEBUG] " . json_encode($payload));
        }
    }
}
