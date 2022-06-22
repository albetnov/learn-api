<?php

/**
 * This it the Init/Entry Point of the API.
 * This file also manages routing.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Albet\LearnApi\CRUD\Tools\Route;
use Albet\LearnApi\Helper;

if (!isset($_GET['url'])) {
    Helper::handleError("URL Query Parameter is required.");
}

header("Access-Control-Allow-Origin: *");

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
    case '/features/expires':
        require_once __DIR__ . '/Features/expires.php';
        break;
    case '/features/timeout':
        require_once __DIR__ . '/Features/timeout.php';
        break;
    case '/features/ratelimit':
        require_once __DIR__ . '/Features/ratelimit.php';
        break;
    case str_starts_with($_GET['url'], '/CRUD'):
        Route::handleRouting($_GET['url']);
        break;
    default:
        Helper::handleError("URL is not valid.", function () {
            http_response_code(404);
        });
}
