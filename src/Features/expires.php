<?php

/**
 * PHP Manual Timeout API Implementation
 * Enter using Postman/Insomnia with configuration (auth=bearer)
 * token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ilhva1JUTGVQSnoiLCJ1c2VybmFtZSI6InJvb3QifQ.-kcpKXGMhnXoqOcFLTu-NKuHYSrXP7kYDzuOfr3z_rg
 * 
 * Some part of the code is from JWT Authentication. So it wont be explained again.
 */

use Albet\LearnApi\Features\Database\DB;
use Albet\LearnApi\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret = "YFC72LDIX<wER}na4}>*,;4tRF'8$&bN!2%!kUmUhaS0xrCa*TEn-zVJme$'oWs";


if (isset($_SERVER['HTTP_GET_TOKEN'])) {
    header("Content-Type: application/json");
    echo json_encode(['token' => JWT::encode([
        'id' => 'XokRTLePJz',
        'username' => 'root'
    ], $secret, 'HS256')]);
    exit;
}

if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    Helper::handleError("Token required.");
}

$token = explode(' ', $_SERVER["HTTP_AUTHORIZATION"])[1];

try {
    $decoded = JWT::decode($token, new Key($secret, 'HS256'));
    // Create a database instance.
    $dbInstance = new DB();

    /**
     * Check if the server are able to communicate with the database.
     */
    if (!$dbInstance) {
        // If not, we will return this message.
        Helper::handleError("A problem occoured on server. Database cannot be accessed. Make sure you have support for SQLite.", function () {
            http_response_code(500);
        });
    }

    // Build the table. If the table already exists, nothing will happen.
    $dbInstance->build();
} catch (\Exception $e) {
    Helper::handleError("Invalid token.");
}

// Search for the user in the database.
$search = $dbInstance->run()->prepare("SELECT * FROM history WHERE id=? LIMIT 1");
$search->execute([$decoded->id]);

// If the user not exist
if (!$search->fetch()) {
    // We will create them.
    $query = "INSERT INTO history (id, RATE_LIMIT, REGISTERED_AT, EXPIRED_AT) VALUES (?,?,?,?)";
    $stmt = $dbInstance->run()->prepare($query);
    $result = $stmt->execute([$decoded->id, 0, time(), time() + (2 * 60)]);
    if (!$result) {
        // If user creation fail, we will return 500.
        Helper::handleError("A problem occoured on server.", function () {
            http_response_code(500);
        });
    }
}

/**
 * You can reset the user expiry time by adding the following header:
 * RESET_USER: true
 */
if (isset($_SERVER['HTTP_RESET_USER'])) {
    $dbInstance->run()->exec("DELETE FROM history WHERE id=\"{$decoded->id}\"");
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'User reset.']);
    exit;
}

// We will re-execute the search to re-search the user.
$search->execute([$decoded->id]);

// and then simply get the first result.
$result = $search->fetchAll()[0];

// Now we will perform some quick calculations to simply apply the expired.
$expiry = $result['EXPIRED_AT'] - $result['REGISTERED_AT'];
$compare = time() - $result['REGISTERED_AT'];


// If the token expired
if ($compare > $expiry) {
    // We will then return that token is expired.
    Helper::handleError("Token expired.");
}

// If everything is fine, we will return the welcome message.
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => "Hello {$decoded->username}!"]);
exit;
