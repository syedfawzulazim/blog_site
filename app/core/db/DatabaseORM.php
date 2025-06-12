<?php
declare(strict_types=1);

namespace App\core\db;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

class DatabaseORM
{
    private static ?EntityManager $entityManager = null;

    public static function create(): EntityManager
    {
        if (self::$entityManager === null) {
            // load .env
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
            $dotenv->safeLoad();

            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [dirname(__DIR__, 3) . '/app/core/db/entity'],
                isDevMode: true
            );

            $dbParams = [
                'dbname'   => $_ENV['DB_NAME'],
                'user'     => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS'],
                'host'     => $_ENV['DB_HOST'],
                'driver'   => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
            ];

            $connection = DriverManager::getConnection($dbParams, $config);
            self::$entityManager = new EntityManager($connection, $config);
        }

        return self::$entityManager;
    }
}