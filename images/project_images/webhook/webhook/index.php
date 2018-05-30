<?php

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
        $config['clientId'],
        $config['clientSecret']
    );

    $response = json_decode($responseRaw);
    if (!isset($response->id)) {
        error_log('[FF] PR: '. $responseRaw);
    }
}

$url = rtrim($config['ciUrl'], '/') . '/' . ltrim($_SERVER['REQUEST_URI'], '/');

$response = ffPassthru($headers, $payloadRaw, $url);

ffResponse(RESP_OK, $response);