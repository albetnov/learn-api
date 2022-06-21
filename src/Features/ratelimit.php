<?php

/**
 * PHP Ratelimit API Implementation
 * Enter using Postman/Insomnia with configuration (auth=bearer)
 * token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IkZ6dUxrc21PbWQiLCJ1c2VybmFtZSI6InJvb3QiLCJyYXRlbGltaXQiOiIzIn0.iLDG-90snWqz7NCP8CsSOkUm5UEX4y176ZeyFL5TAeA
 * 
 * Some part of the code is from JWT Authentication. So it wont be explained again.
 */

use Albet\LearnApi\Features\Database\DB;
use Albet\LearnApi\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret = "YFC72LDIX<wER}na4}>*,;4tRF'8$&bN!2%!kUmUhaS0xrCa*TEn-zVJme$'yuz";

/**
 * Claim your token by adding the following to the header:
 * GET_TOKEN: true
 */
if (isset($_SERVER['HTTP_GET_TOKEN'])) {
    header("Content-Type: application/json");
    echo json_encode(['token' => JWT::encode([
        'id' => 'FzuLksmOmd',
        'username' => 'root',
        'ratelimit' => '3'
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
    $query = "INSERT INTO history (id, RATE_LIMIT, REGISTERED_AT, EXPIRED_AT, ACTIVATED_AFTER) VALUES (?,?,?,?,?)";
    $stmt = $dbInstance->run()->prepare($query);
    $result = $stmt->execute([$decoded->id, 0, time(), time() + (2 * 60), 0]);
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

// Now we will check if the token is registered for how long.
$compare = time() - $result['REGISTERED_AT'];

// If the token is registered for less than ACTIVATED_AFTER in database, we will return this message.
if ($compare < (int) $result['ACTIVATED_AFTER']) {
    // We will then return that token invalid again.
    Helper::handleError("Invalid token.");
}

// If the rate limit has been reached
if ($result['RATE_LIMIT'] >= $decoded->ratelimit) {
    // We will return this.
    Helper::handleError("Ratelimit exceeded.", function () use ($dbInstance, $decoded) {
        // The code below are extras.
        // Eventually you can also query to ACTIVATED_AFTER and then clear the ratelimit to refresh ratelimit.
        // Don't forget to reset REGISTER_AT to current time.
        $query = "UPDATE history SET RATE_LIMIT=?, ACTIVATED_AFTER=?, REGISTERED_AT=? WHERE id=?";
        $stmt = $dbInstance->run()->prepare($query);
        $stmt->execute([0, 120, time(), $decoded->id]);
    });
}

// Query to the database to update the current user hit.
$query = "UPDATE history SET RATE_LIMIT=? WHERE id=?";
$stmt = $dbInstance->run()->prepare($query);
$stmt->execute([$result['RATE_LIMIT'] + 1, $decoded->id]);

// If everything is fine, we will return the welcome message.
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => "Hello {$decoded->username}!"]);
exit;
