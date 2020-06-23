<?php

use function WebhookCiProxy\getHeaders;
use function WebhookCiProxy\isPrRefreshRequired;
use function WebhookCiProxy\passPayloadToCi;
use function WebhookCiProxy\refreshPr;
use function WebhookCiProxy\sendResponse;
use const WebhookCiProxy\HTTP_STATUS_BAD_REQUEST;
use const WebhookCiProxy\HTTP_STATUS_OK;

ini_set('display_errors', false);
error_reporting(-1);

require_once 'functions.php';

$payloadRaw = file_get_contents('php://input');
$payload = json_decode($payloadRaw);
$headers = getHeaders();

if (!isset($headers['X-GitHub-Event']) || !$payload) {
    sendResponse(HTTP_STATUS_BAD_REQUEST);
}

if ($headers['X-GitHub-Event'] === 'pull_request'
    && isset($payload->number)
    && isset($payload->action)
    && isPrRefreshRequired($payload->action)
) {
    $responseRaw = refreshPr(
        $payload->repository->owner->login,
        $payload->repository->name,
        $payload->number,
        getenv('WEBHOOK_CI_PROXY_ACCESS_TOKEN')
    );

    $response = json_decode($responseRaw);
    if (!isset($response->id)) {
        error_log('[Webhook CI Proxy] PR: ' . var_export($responseRaw, true));
    }
}

$url = rtrim(getenv('WEBHOOK_CI_PROXY_CI_URL'), '/') . '/' . ltrim($_SERVER['REQUEST_URI'], '/');

$response = passPayloadToCi($headers, $payloadRaw, $url);

sendResponse(HTTP_STATUS_OK, '[Webhook CI Proxy] ' . $response);