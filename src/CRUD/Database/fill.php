<?php

/**
 * This file will fill the database.
 * Execute this file by performing "php fill.php".
 * Clear the database by performing "php fill.php drop".
 */

use Albet\LearnApi\CRUD\Database\DB;

require_once __DIR__ . '/../../../vendor/autoload.php';

DB::prepare();

if (isset($argv[1]) && $argv[1] == "drop") {
    if (!DB::drop()) echo 'Database drop error\n';
    echo "Done.\n";
    exit;
}

if (!DB::check()) {
    echo "Building database...\n";
    if (!DB::build()) echo "Building database failed.\n";
    echo "Done.\n";
    echo "Filling database...\n";
    if (!DB::fill()) echo "Filling database failed.\n";
    echo "Done.\n";
    exit;
}

echo "Database already exists.\n";
exit;
