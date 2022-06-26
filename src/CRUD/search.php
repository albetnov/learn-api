<?PHP

/**
 * PHP Restful API Implementation for searching data.
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
 * In here we will check the query for search.
 * Simply by splitting the url and getting the last part of array.
 * Tips: If you unsure about the array size, you can get it with array_key_last() function.
 */
$query = explode('/', $_GET['url'])[3] ?? false;
if (!$query) {
    // If it's null we will return this message
    Helper::handleError("Search query required.");
}

header('Content-Type: application/json');

/**
 * Then we simply query to the database.
 * Based on url search query.
 */
$db = new DB();
$stmt = $db->run()->prepare("SELECT * FROM ticket WHERE ticket_type LIKE ?");
$stmt->execute(["%{$query}%"]);
$data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

// And output the data.
echo json_encode($data);
exit;
