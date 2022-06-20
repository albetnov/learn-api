<?php

namespace Albet\LearnApi\Features\Database;

class DB
{
    private $connection;
    public function __construct()
    {
        try {
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
                            EXPIRED_AT DATETIME NOT NULL
                        );
                    Table;
            $table = $this->connection->exec($query);
            if (!$table) {
                echo "Error creating table.";
            }
        }
    }

    public function run()
    {
        return $this->connection;
    }
}
