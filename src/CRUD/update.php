<?PHP

/**
 * PHP Restful API Implementation for updating data.
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

/**
 * Now we will check if user has given id.
 */
$id = explode('/', $_GET['url'])[3] ?? false;
if (!$id) {
    // If it's null we will return this message
    Helper::handleError("Id required.");
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
    if ((isset($data['ticket_number']) && is_numeric($data['ticket_number'])) || isset($data['ticket_type']) || isset($data['desc'])) {
        return true;
    }

    return false;
}

// Execute the function.
if (!validateData($parsed)) {
    // IF the format unmatch. We return this message
    Helper::handleError("Invalid data. Please check the JSON format.");
};

header('Content-Type: application/json');

/**
 * Update the data to database according to the JSON sended by user.
 */
$db = new DB();

// Since the data updated can be flexible, we need to build query according to user new data.
$query = "UPDATE TICKET SET ";
$content = [];
foreach ($parsed as $key => $value) {
    $query .= $key . " =?, ";
    $content[] = $value;
}
$query = substr($query, 0, -2) . " WHERE id=?";
$stmt = $db->run()->prepare($query);
$status = $stmt->execute([...$content, $id]);

if ($status) {
    echo json_encode(['status' => 'success']);
} else {
    Helper::handleError("Error while updating data.");
}

exit;
