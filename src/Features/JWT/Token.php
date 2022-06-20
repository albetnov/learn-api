<?php

namespace Albet\LearnApi\Features\JWT;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * PHP Token Handler
 * This PHP File with generated JWT's based cresidentials to be used in bearer.
 */
class Token
{
    private static $token;
    private const KEY = "2ZuAS:nj{DR!lvh(k@rsG|<+vx#x(zP]x)A34W.#v2nm8I^]j*2hxQeb]30aIq6";

    public static function getToken()
    {
        return self::$token;
    }

    public function generateToken($with = null)
    {
        $payload = [
            'iss' => 'localhost', // Token Verification Field (usually URL)
            'aud' => 'localhost', // This field for the client to determine if the token was issued for them. Usually list of string.
            'iat' => time(), // JWT Token Creation Time
        ];

        if ($with == "nbf") {
            $payload['nbf'] = time() + 60; // Time before JWT finally able to use. You need to wait for 1 minute until your token can be used.
        } else if ($with == "exp") {
            $payload['exp'] = time() + (2 * 60); // JWT Token Expiration Time. Your token will be expired after 2 minutes.
        }

        self::$token = JWT::encode($payload, self::KEY, 'HS512');
    }

    public static function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key(self::KEY, 'HS512'));
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (PHP_SAPI == 'cli') {
    $token = new Token();
    $option = $argv[1] == "timeout" ? "nbf" : "exp";
    $token->generateToken($option);
    echo Token::getToken();
}
