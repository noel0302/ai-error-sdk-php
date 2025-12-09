<?php

namespace AI\ErrorSDK;

use InvalidArgumentException;

class AIConfig
{
    /** @var string */
    public $projectKey;

    /** @var string */
    public $env;

    /** @var string */
    public $apiUrl;

    /** @var bool */
    public $debug;

    public function __construct($projectKey, $env, $apiUrl, $debug = false)
    {
        if (empty($projectKey)) {
            throw new InvalidArgumentException("projectKey is required");
        }
        if (empty($env)) {
            throw new InvalidArgumentException("env is required");
        }
        if (empty($apiUrl)) {
            throw new InvalidArgumentException("apiUrl is required");
        }

        $this->projectKey = (string)$projectKey;
        $this->env        = (string)$env;
        $this->apiUrl     = (string)$apiUrl;
        $this->debug      = (bool)$debug;
    }
}
