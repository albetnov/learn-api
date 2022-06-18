<?php

/**
 * PHP API JWT Authentication
 * An JWT Implementation for PHP API.
 * Enter using Postman/Insomnia with (auth=bearer):
 * token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpZCI6MSwibmFtZSI6InVzZXIiLCJyb2xlIjoidXNlciJ9.J_N0u8ZlleSoG0Iy2ZKkD3qYvGdqPwpS3fBdv_NoEyWoUy8_BEPO0y9T7j0T7lT_L5qvbdEVWXNCiAjaOclRzg
 */

declare(strict_types=1);

use Albet\LearnApi\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * This is the secret key defined for JWT. Please to secure this key carefully.
 * I used password generator to generate the strong secret key.
 */
$secret = "pe5EoM6mnyCt23aQCRhVhusR39XpxGzyg4JUYARD5PSYkoaP2dTfuiXySicBxSmK";

/**  
 * First of all, we will generate the token. The token can be gathered from the user login or anything like Restful Login.
 * The token will be generated using the JWT library. Variables defined below is a mock data.
 */
$user = [
    "id" => 1,
    "name" => "user",
    "role" => "user"
];


/**
 * The user variable is the payload or data. Meanwhile the key is the password required to verify the token.
 * HS512 is one of the algorithms used for generating the token.
 */
$token = JWT::encode($user, $secret, "HS512");

/**
 * To get the token or regenerate it you can put this in your header:
 * GET_TOKEN=true while requesting to this endpoint. 
 * Putting GET_TOKEN will disable the API Authentication.
 * This features are used for development purpose only.
 */
if (isset($_SERVER["HTTP_GET_TOKEN"]) && $_SERVER["HTTP_GET_TOKEN"] == "true") {
    header("Content-Type:application/json");
    echo json_encode(['status' => 'success', 'token' => $token]);
    exit;
}


/**
 * We will explode the HTTP Authorization to get the token.
 * Then assign it to $token vraible.
 */
$token = explode(' ', $_SERVER["HTTP_AUTHORIZATION"])[1];

/** 
 * We will check if the token is valid or not.
 */
try {
    JWT::decode($token, new Key($secret, 'HS512'));

    // If the token do valid we will return the welcome message.
    header("Content-Type: application/json");
    echo json_encode(['status' => 'success', 'message' => "welcome"]);
    exit;
} catch (\Exception $e) {
    // If not we will return the error message.
    Helper::handleError();
}
