<?PHP

/**
 * PHP Restful API Implementation for fetching single data.
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
 * In here we will check the ID. Simply by splitting the URL.
 * If it's null or not defined we basically return null
 */
$id = explode('/', $_GET['url'])[3] ?? false;
if (!$id) {
    // If it's null we will return this message
    Helper::handleError("Id required.");
}

header('Content-Type: application/json');

/**
 * Then we simply query to the database.
 * Based on url id.
 */
$db = new DB();
$stmt = $db->run()->prepare("SELECT * FROM ticket WHERE ID=? LIMIT 1");
$stmt->execute([$id]);
$data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

// And output the data.
echo json_encode($data);
exit;
