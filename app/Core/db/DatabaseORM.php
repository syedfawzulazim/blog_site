<?php
declare(strict_types=1);

namespace App\Core\Db;

use App\Core\ErrorHandler;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception\ConnectionException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

class DatabaseORM
{
    private static ?EntityManager $entityManager = null;

    public static function getInstance(): EntityManager
    {
        if (self::$entityManager === null) {
            try {
                // Load environment variables
                $dotenv = Dotenv::createImmutable(dirname(__DIR__, 3));
                $dotenv->safeLoad();

                $config = ORMSetup::createAttributeMetadataConfiguration(
                    paths: [dirname(__DIR__, 3) . '/app/Models/Entities'],
                    isDevMode: true
                );

                $dbParams = [
                    'dbname'   => $_ENV['DB_NAME'],
                    'user'     => $_ENV['DB_USER'],
                    'password' => $_ENV['DB_PASS'],
                    'host'     => $_ENV['DB_HOST'],
                    'driver'   => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
                ];

                try {
                    $connection = DriverManager::getConnection($dbParams, $config);
                    self::$entityManager = new EntityManager($connection, $config);
                } catch (ConnectionException $e) {
                    ErrorHandler::getInstance()->handleError($e);
                    throw new \RuntimeException('Failed to connect to the database. Please check your database configuration.');
                }

            } catch (InvalidPathException $e) {
                ErrorHandler::getInstance()->handleError($e);
                throw new \RuntimeException('Environment file (.env) not found or invalid.');
            } catch (ORMException $e) {
                ErrorHandler::getInstance()->handleError($e);
                throw new \RuntimeException('Failed to initialize ORM configuration.');
            }
        }

        return self::$entityManager;
    }
}