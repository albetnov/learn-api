<?php

namespace Albet\LearnApi\Features\Database;


/**
 * This is a database interface to the database.
 */
class DB
{
    private $connection;
    public function __construct()
    {
        try {
            // Fell free to custom this PDO. You can also change it to MySQL if you want to.
            $this->connection = new \PDO("sqlite:" . __DIR__ . "/history.db");
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function build(): void
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM history");
            $result = $stmt->execute();
        } catch (\PDOException $e) {
            $query = <<<Table
                        CREATE TABLE history (
                            ID VARCHAR(225) PRIMARY KEY NOT NULL,
                            RATE_LIMIT INT NOT NULL,
                            REGISTERED_AT DATETIME NOT NULL,
                            EXPIRED_AT DATETIME NOT NULL,
                            ACTIVATED_AFTER DATETIME NOT NULL
                        );
                    Table;
            $this->connection->exec($query);
        }
    }

    public function run()
    {
        return $this->connection;
    }
}
