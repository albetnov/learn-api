<?PHP

/**
 * PHP Restful API Implementation for fetching data.
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

header('Content-Type: application/json');

/**
 * We simply fetch the database. So make sure to run fill.php first to fill your database with the dummy data.
 */
$db = new DB();
$result = $db->run()->query("SELECT * FROM ticket");
$data = $result->fetchAll(\PDO::FETCH_ASSOC);

/**
 * After that we will map the array. So it will return anything we need only.
 * Actually we can also use filter for this.
 */
$output = array_map(function ($data) {
    return [
        'ticket_id' => $data['ID'],
        'ticket' => $data['ticket_type'],
    ];
}, $data);

// Return the mapped data
echo json_encode($output);
exit;
