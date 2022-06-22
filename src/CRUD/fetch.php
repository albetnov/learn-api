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

$db = new DB();
$result = $db->run()->query("SELECT * FROM ticket");
$data = $result->fetchAll(\PDO::FETCH_ASSOC);

$output = array_map(function ($data) {
    return [
        'ticket_id' => $data['ID'],
        'ticket' => $data['ticket_type'],
    ];
}, $data);

echo json_encode($output);
exit;
