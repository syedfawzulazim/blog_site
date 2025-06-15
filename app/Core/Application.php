<?php
declare(strict_types=1);

namespace App\Core;

use App\core\db\DatabaseORM;
use App\Core\DI\Container;
use Doctrine\ORM\EntityManager;

class Application
{
    private static Application $instance;
    private Routes $routes;
    private Container $container;

    public function __construct()
    {
        self::$instance = $this;
        $this->container = Container::getInstance();
        $this->initialize();
    }

    public static function getInstance(): Application
    {
        return self::$instance;
    }

    private function initialize(): void
    {
        // Start session
        $this->startSession();

        // Load environment variables
        $this->loadEnvironment();

        $this->registerEntityManager();
        

        // Initialize routes
        $this->routes = new Routes();
    }

    private function loadEnvironment(): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

    }

    private function registerEntityManager(): void
    {
        $this->container->set(DatabaseORM::class, function (){
            return new DatabaseORM(
                $_ENV['DB_NAME'],
                $_ENV['DB_HOST'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
            );
        });
        // Register EntityManager
        $this->container->set(EntityManager::class, function () {
            return $this->container->get(DatabaseORM::class)->initialize();
        });
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function run(): void
    {
        $this->routes->dispatch();
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
} 