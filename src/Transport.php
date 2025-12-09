<?php

namespace AI\ErrorSDK;

use AI\ErrorSDK\models\ErrorPayload;

require_once __DIR__ . '/models/ErrorPayload.php';

class Transport
{
    private $apiUrl;
    private $projectKey;

    public function __construct(AIConfig $config)
    {
        $this->apiUrl     = $config->apiUrl;
        $this->projectKey = $config->projectKey;
    }

    public function send(ErrorPayload $payload)
    {
        $payload->projectKey = $this->projectKey;

        $json = json_encode($payload);

        $ch = curl_init($this->apiUrl);

        curl_setopt_array($ch, [
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => $json,
            CURLOPT_HTTPHEADER      => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CONNECTTIMEOUT  => 3,
            CURLOPT_TIMEOUT         => 3
        ]);

        curl_exec($ch);
        curl_close($ch);
    }
}
