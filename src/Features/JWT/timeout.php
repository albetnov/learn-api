<?php

/**
 * PHP Timeout API Implementation
 * Enter using Postman/Insomnia with configuration (auth=bearer)
 * Please get your token by running token.php file: "php token.php timeout".
 */

declare(strict_types=1);

use Albet\LearnApi\Features\JWT\Token;
use Albet\LearnApi\Helper;

if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
    Helper::handleError("Token is required.");
}

$token = explode(' ', $_SERVER["HTTP_AUTHORIZATION"])[1];

$decoded = Token::validateToken($token);

if (!$decoded) {
    Helper::handleError("Token invalid.");
}

// You will be greeted by the message "welcome" if the token is valid. It's took 1 minute for your token to be valid.
header("Content-Type: application/json");
echo json_encode(["status" => "success", "message" => "welcome"]);
exit;
