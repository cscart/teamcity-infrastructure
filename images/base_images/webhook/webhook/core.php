<?php

define('RESP_BAD_REQUEST', 400);
define('RESP_OK', 200);

/**
 * Sends response.
 *
 * @param int    $status HTTP code
 * @param string $body   Response body
 */
function ffResponse($status = RESP_OK, $body = '')
{
    $protocol = isset($_SERVER['SERVER_PROTOCOL'])
        ? $_SERVER['SERVER_PROTOCOL']
        : 'HTTP/1.0';

    header($protocol . ' ' . $status);

    if ($body !== '') {
        echo $body;
    }

    exit((int) ($status !== RESP_OK));
}

/**
 * Gets request headers.
 *
 * @return string[]
 */
function ffGetHeaders()
{
    $headers = [];

    foreach ($_SERVER as $key => $value) {
        if (strpos($key, 'HTTP_') !== 0) {
            continue;
        }

        $key = explode('_', strtolower($key));
        array_shift($key);
        $key = array_map('ucfirst', $key);
        $key = implode('-', $key);
        $key = str_replace('Github', 'GitHub', $key);

        $headers[$key] = $value;
    }

    return $headers;
}

/**
 * Checks whether PR refresh status API request should be sent for the PR action.
 *
 * @param string $action Webhook PR action
 *
 * @return bool
 */
function ffIsPrRefreshRequired($action)
{
    return $action == 'opened' || $action == 'reopened' || $action == 'synchronize';
}

/**
 * Performs API request to refresh PR status.
 *
 * @param string $owner
 * @param string $repo
 * @param int    $number
 * @param string $accessToken
 *
 * @return string
 */
function ffRefreshPr($owner, $repo, $number, $accessToken)
{
    $url = sprintf(
        'https://api.github.com/repos/%s/%s/pulls/%d?access_token=%s',
        $owner,
        $repo,
        $number,
        $accessToken
    );

    $context = stream_context_create([
        'http' => [
            'header'        => 'User-Agent: Firefly CI Proxy',
            'method'        => 'GET',
            'ignore_errors' => true,
        ],
    ]);

    return file_get_contents($url, false, $context);
}

/**
 * Passes webhook payload as-is to CI.
 *
 * @param array  $headers Request headers
 * @param string $payload Payload body
 * @param string $url     CI URL to send payload to
 *
 * @return string CI response
 */
function ffPassthru(array $headers, $payload, $url)
{
    $headersString = '';
    foreach ($headers as $name => $value) {
        $headersString .= $name . ': ' . $value . "\r\n";
    }

    $context = stream_context_create([
        'http' => [
            'header'        => $headersString,
            'method'        => 'POST',
            'content'       => $payload,
            'ignore_errors' => true,
        ],
    ]);

    return file_get_contents($url, false, $context);
}
