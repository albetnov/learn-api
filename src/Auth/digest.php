<?php

/**
 * PHP API Digest Authentication
 * Warning: Digest has been deprected by a lot of software.
 * Ref: https://github.com/symfony/symfony/issues/24325
 * An Digest Authentication Implementation for PHP API.
 * Enter using Postman/Insomnia with (auth=digest):
 * username: root
 * password: root123
 */

declare(strict_types=1);

use Albet\LearnApi\Helper;

// Since the realm may be used multiple times. It's better to define them as constant.
define("REALM", "API");

/**
 * First we will define the user (dummy will do.)
 */
$user = ['username' => 'root', 'password' => 'root123'];

// Check if user put the cresidentials or not.
if (!isset($_SERVER['PHP_AUTH_DIGEST'])) {
    // If not we will return the error json.
    Helper::handleError(null, function () {
        $opaque = md5(REALM);
        // We also will inform the user to login using digest.
        header("WWW-Authenticate: Digest realm=\"" . REALM . "\", qop=\"auth\", nonce=\"" . uniqid() . "\", opaque=\"{$opaque}\"");
    });
}

/**
 * This function will parse the digest header.
 * 
 * @param string $txt
 * 
 * @return string
 */
function http_digest_parse($txt)
{
    // protect against missing data
    $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

// We will parse the digest header.
$parsed = http_digest_parse($_SERVER['PHP_AUTH_DIGEST']);

// If the username is not the same as our dummy data
if ($parsed['username'] != $user['username']) {
    // We will return error json
    Helper::handleError("Wrong cresidentials.");
}

// Now we will check the password.
$A1 = md5($parsed['username'] . ':' . REALM . ':' . $user['password']);
$A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $parsed['uri']);
$valid_response = md5($A1 . ':' . $parsed['nonce'] . ':' . $parsed['nc'] . ':' . $parsed['cnonce'] . ':' . $parsed['qop'] . ':' . $A2);

// If the password is not equal as our dummy data
if ($parsed['response'] != $valid_response) {
    // We will return error json
    Helper::handleError("Wrong cresidentials.");
}

// If everything is ok, we will return the json.
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => 'welcome']);
exit;
