<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Albet\LearnApi\Helper;

if (!isset($_GET['url'])) {
    Helper::handleError("URL Query Parameter is required.");
}

switch ($_GET['url']) {
    case '/basic':
        require_once __DIR__ . '/Auth/basic.php';
        break;
    case '/jwt':
        require_once __DIR__ . '/Auth/jwt.php';
        break;
    case '/query':
        require_once __DIR__ . '/Auth/query.php';
        break;
    default:
        Helper::handleError("URL is not valid.");
}
