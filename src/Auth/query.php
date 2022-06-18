<?php

/**
 * PHP API Query Parameter Authentication
 * Enter using Postman/Insomnia with configuration (url={basepath}/index.php?url=/query&api_key={api_key}):
 * api_key: root123
 */

declare(strict_types=1);

use Albet\LearnApi\Helper;

/**
 * The following line will check if the user is put the cresidentials or not.
 * The cresidentials are defined in route query parameter.
 */
if (!isset($_GET['api_key'])) {
    // If there's no query. We will give the following error json to them.
    Helper::handleError();
} else {
    // If the user do put the cresidentials we will check if it correct or not.
    if ($_GET['api_key'] == "root123") {
        // If it's correct then we will return the json.
        header("Content-Type: application/json");
        echo json_encode(["status" => "success", "message" => "welcome"]);
        exit;
    } else {
        // If not we simply return the error json again.
        Helper::handleError();
    }
}
