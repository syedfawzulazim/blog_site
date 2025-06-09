<?php
declare(strict_types=1);

namespace App\core;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database{
    private static ?Database $instance = null;
    private PDO $connection;

    public function __construct()
    {
        $this->loadEnv();
        $this->connect();
    }

    public static function getInstance(): Database
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadEnv(): void
    {
        $root = dirname(__DIR__,2);
        $dotenv = Dotenv::createImmutable($root);
        $dotenv->load();
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
            echo "Database Connection Successful";
        } catch (PDOException $e){
            die("Database connection failed : " .$e->getMessage());
        }
    }

    public function getConnection():PDO
    {
        return $this->connection;
    }
}