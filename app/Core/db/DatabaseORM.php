<?php
declare(strict_types=1);

namespace App\Core\Db;

use App\Core\ErrorHandler;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception\ConnectionException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMSetup;
use Dotenv\Exception\InvalidPathException;

class DatabaseORM
{
    private static ?EntityManager $entityManager = null;

    public function __construct(
        private readonly string $dbname,
        private readonly string $host,
        private readonly string $user,
        private readonly string $password,
        private readonly string $driver,

    ){
        $this->initialize();
    }

    public function initialize(): EntityManager
    {
        if (self::$entityManager === null) {
            try {
                $config = ORMSetup::createAttributeMetadataConfiguration(
                    paths: [dirname(__DIR__, 3) . '/app/Models/Entities'],
                    isDevMode: true
                );

                $dbParams = [
                    'dbname'   => $this->dbname,
                    'user'     => $this->user,
                    'password' => $this->password,
                    'host'     => $this->host,
                    'driver'   =>$this->driver,
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