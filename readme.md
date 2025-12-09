# AI Error SDK for PHP

## Install
composer require ai-error/sdk

## Usage
use AI\ErrorSDK\AIError;

AIError::init([
    'projectKey' => 'YOUR_PROJECT_KEY',   // projectKey
    'env'        => 'prod',               // prod, dev
    'apiUrl'     => 'AGENT_SERVER_URL',   // apiUrl
    'debug'      => false                 // debug
]);