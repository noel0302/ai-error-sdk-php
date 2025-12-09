<?php

namespace AI\ErrorSDK\models;

class ErrorPayload
{
    /** @var string */
    public $projectKey;

    /** @var string */
    public $env;

    /** @var string */
    public $message;

    /** @var string */
    public $type;

    /** @var string */
    public $file;

    /** @var int */
    public $line;

    /** @var string */
    public $stack;

    /** @var string */
    public $timestamp;
}
