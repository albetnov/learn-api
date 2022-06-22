<?php

namespace Albet\LearnApi\CRUD\Database;

use Faker\Factory;

/**
 * A database interface
 */
class DB
{

    private static $connection;

    public static function prepare()
    {
        self::$connection = new \PDO("sqlite:" . __DIR__ . "/crud.db");
    }

    public function __construct()
    {
        self::prepare();
    }

    public static function check(): bool
    {
        try {
            $stmt = self::$connection->prepare("SELECT * FROM ticket");
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function build(): bool
    {
        try {
            $query = <<<query
            CREATE TABLE ticket (
                ID VARCHAR(225) PRIMARY KEY NOT NULL,
                ticket_number INT NOT NULL,
                ticket_type VARCHAR(225) NOT NULL,
                DESC TEXT NOT NULL
            );
            query;
            self::$connection->exec($query);
            return true;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    public static function fill(): bool
    {
        try {
            $query = "INSERT INTO ticket (ID, ticket_number, ticket_type, DESC) VALUES (?,?,?,?)";
            $stmt = self::$connection->prepare($query);
            $faker = Factory::create();
            for ($i = 0; $i < 10; $i++) {
                $stmt->execute([
                    $faker->bothify("?????-#####"),
                    $faker->randomNumber(6, true),
                    $faker->randomElement(["VIP", "Regular", "Business", "First Class"]),
                    $faker->paragraph()
                ]);
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function drop(): bool
    {
        try {
            self::$connection->exec("DROP TABLE ticket");
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function run(): \PDO
    {
        return self::$connection;
    }
}
