<?php

/**
 * PHP Restful API Implementation for Uploading data.
 * Note: Your uploaded file should appear at "src/CRUD/files" directory.
 * Enter using Postman/Insomnia with configuration (auth=bearer)
 * token: (Please get it by running "php token.php" located in: src/CRUD/Tools/token.php.
 * 
 * Some part of the code is from JWT Authentication. So it wont be explained again.
 */

use Albet\LearnApi\CRUD\Tools\Token;
use Albet\LearnApi\Helper;

if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    Helper::handleError("Token required.");
}

$token = explode(' ', $_SERVER["HTTP_AUTHORIZATION"])[1];

if (!Token::validateToken($token)) {
    Helper::handleError("Invalid token.");
}

header('Content-Type: application/json');

// Check if the user are asking to upload data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // If the user give the file.
    if (isset($_FILES['file']) && is_uploaded_file($_FILES['file']["tmp_name"])) {
        $tmpFile = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $uploadedDir = __DIR__ . "/Files/" . $fileName;

        // We upload it
        if (move_uploaded_file($tmpFile, $uploadedDir)) {
            echo json_encode(['success' => "success", 'message' => 'File uploaded successfully.']);
            exit;
        } else {
            // In case it failed, we return this message.
            Helper::handleError("Error uploading file");
        }
    } else {
        // If the user didn't provide the file, then we return this message.
        Helper::handleError();
    }
    // If the user are asking to view the uploaded file.
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // We will scan the "files/" directory for files.
    $filesList = array_diff(scandir(__DIR__ . '/Files'), ['.', '..', '.gitkeep']);
    $output = array_map(function ($data) {
        return ['file' => $data];
    }, $filesList);
    // Then return it to user.
    echo json_encode($output);
    exit;
}
