<?php

ini_set('display_errors', false);
error_reporting(-1);

require_once 'core.php';
$config = require_once 'config.php';

$payloadRaw = file_get_contents('php://input');
$payload = json_decode($payloadRaw);
$headers = ffGetHeaders();

if (!isset($headers['X-GitHub-Event']) || !$payload) {
    ffResponse(RESP_BAD_REQUEST);
}

if ($headers['X-GitHub-Event'] === 'pull_request'
    && isset($payload->number)
    && isset($payload->action)
    && ffIsPrRefreshRequired($payload->action)
) {
    $responseRaw = ffRefreshPr(
        $payload->repository->owner->login,
        $payload->repository->name,
        $payload->number,
        $config['accessToken']
    );

    $response = json_decode($responseRaw);
    if (!isset($response->id)) {
        error_log('[FF] PR: ' . var_export($responseRaw, true));
    }
}

$url = rtrim($config['ciUrl'], '/') . '/' . ltrim($_SERVER['REQUEST_URI'], '/');

$response = ffPassthru($headers, $payloadRaw, $url);

ffResponse(RESP_OK, '[FF] ' . $response);