<?php

/**
 * Init file to check whenever the database has been initialized or not.
 * You can initialized the database by running "php fill.php" located in: src/CRUD/Database/fill.php
 */

use Albet\LearnApi\CRUD\Database\DB;
use Albet\LearnApi\Helper;

DB::prepare();

// If the database has not been initialized
if (!DB::check()) {
    // We return this error message.
    Helper::handleError('Database error. Problem on server.', function () {
        http_response_code(500);
    });
};
