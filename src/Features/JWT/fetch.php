<?php

/**
 * Client Entry Point for getting Token Key
 */

use Albet\LearnApi\Features\JWT\Token;
use Albet\LearnApi\Helper;

if (!isset($_GET['type'])) {
    Helper::handleError("Type Query Parameter is required.");
}

$token = new Token();

if ($_GET['type'] == "timeout") {
    $token->generateToken("nbf");
} else if ($_GET['type'] == 'expires') {
    $token->generateToken("exp");
}

header("Content-Type: application/json");
echo json_encode(['token' => Token::getToken()]);
