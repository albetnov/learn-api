<?php

/**
 * PHP Basic Authentication
 * Enter using Postman/Insomnia with configuration (Auth=basic):
 * username: root
 * password: root123
 */

declare(strict_types=1);

use Albet\LearnApi\Helper;

/**
 * The following line will check if the user is put the cresidentials or not.
 */
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    // If not we simply return the json which said that the user is not authorized.
    Helper::handleError(null, function () {
        // This header simply to tell the user that authorization is required.
        header("WWW-Authenticate: Basic realm=\"API\"");
    });
} else {
    // If the user do put the cresidentials than we execute this.
    if ($_SERVER['PHP_AUTH_USER'] == "root" && $_SERVER['PHP_AUTH_PW'] == "root123") {
        // If the cresidentials correct, we will reponse the message welcome.
        header("Content-Type: application/json");
        echo json_encode(["status" => "success", "message" => "welcome"]);
        exit;
    } else {
        // If not than we throw the error again.
        Helper::handleError();
    }
}
