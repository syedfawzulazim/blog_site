<?php
declare(strict_types=1);

namespace App\Core\Database;

use PDO;
use PDOException;

class DatabasePDO{
    private static ?DatabasePDO $instance = null;
    private PDO $connection;

    public function __construct()
    {
        $this->connect();
    }

    public static function getInstance(): DatabasePDO
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect(): void
    {
        try {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];

            $dsn = "mysql:host={$host};dbname={$dbname}";
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "DatabasePDO Connection Successful <br>";
        } catch (PDOException $e){
            die("DatabasePDO connection failed : " .$e->getMessage());
        }
    }

    public function getConnection():PDO
    {
        return $this->connection;
    }
}