<?php

namespace Albet\LearnApi\CRUD\Tools;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../../vendor/autoload.php';

/**
 * PHP Token Handler
 * This PHP File with generated JWT's based cresidentials to be used in bearer.
 */
class Token
{
    private static $token;
    private const KEY = "(BgNQm?M<;%vK8N2rXiAnqUCX_.[Q&oT6NHxt-3~05c*W:(7v=q#L&!{1^3}";

    public static function getToken()
    {
        return self::$token;
    }

    public function generateToken()
    {
        $payload = [
            'username' => 'root',
            'uid' => 'sBWMtD<jtTrY{cp&@mFV'
        ];

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
    $token->generateToken();
    echo Token::getToken();
}
