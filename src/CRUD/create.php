<?PHP

/**
 * PHP Restful API Implementation for creating data.
 * Enter using Postman/Insomnia with configuration (auth=bearer)
 * token: (Please get it by running "php token.php" located in: src/CRUD/Tools/token.php.
 * 
 * Some part of the code is from JWT Authentication. So it wont be explained again.
 */

use Albet\LearnApi\CRUD\Database\DB;
use Albet\LearnApi\CRUD\Tools\Token;
use Albet\LearnApi\Helper;

if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    Helper::handleError("Token required.");
}

$token = explode(' ', $_SERVER["HTTP_AUTHORIZATION"])[1];

if (!Token::validateToken($token)) {
    Helper::handleError("Invalid token.");
}

$data = file_get_contents('php://input');
if (!$data) {
    Helper::handleError("Data not found. Please sent it with JSON format.");
}

// Before we insert the data, we need to ensure that the JSON Format match the specification.
try {
    $parsed = json_decode($data, true);
} catch (\Exception $e) {
    Helper::handleError("Invalid JSON format.");
}

function validateData($data)
{
    if (!isset($data['id']) || !isset($data['ticket_number']) || !isset($data['ticket_type']) || !isset($data['desc'])) {
        return false;
    }

    if (is_numeric($data['ticket_number']) != 1) {
        return false;
    }

    return true;
}

// Execute the function.
if (!validateData($parsed)) {
    // IF the format unmatch. We return this message
    Helper::handleError("Invalid data. Please check the JSON format.");
};

header('Content-Type: application/json');

/**
 * Insert the data to database according to the JSON sended by user.
 */
$db = new DB();
$stmt = $db->run()->prepare("INSERT INTO ticket (ID, ticket_number, ticket_type, DESC) VALUES (?,?,?,?)");
$status = $stmt->execute([$parsed['id'], $parsed['ticket_number'], $parsed['ticket_type'], $parsed['desc']]);

if ($status) {
    echo json_encode(['status' => 'success']);
} else {
    Helper::handleError("Error while inserting data.");
}

exit;
