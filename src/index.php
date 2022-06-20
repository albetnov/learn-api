<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Albet\LearnApi\Helper;

if (!isset($_GET['url'])) {
    Helper::handleError("URL Query Parameter is required.");
}

switch ($_GET['url']) {
    case '/auth/basic':
        require_once __DIR__ . '/Auth/basic.php';
        break;
    case '/auth/jwt':
        require_once __DIR__ . '/Auth/jwt.php';
        break;
    case '/auth/query':
        require_once __DIR__ . '/Auth/query.php';
        break;
    case '/auth/digest':
        require_once __DIR__ . '/Auth/digest.php';
        break;
    case '/features/JWT/fetch':
        require_once __DIR__ . '/Features/JWT/fetch.php';
        break;
    case '/features/JWT/timeout':
        require_once __DIR__ . '/Features/JWT/timeout.php';
        break;
    case '/features/JWT/expires':
        require_once __DIR__ . '/Features/JWT/expires.php';
        break;
    default:
        Helper::handleError("URL is not valid.", function () {
            http_response_code(404);
        });
}
