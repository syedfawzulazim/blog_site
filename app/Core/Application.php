<?php
declare(strict_types=1);

namespace App\Core;

use App\core\db\DatabaseORM;

class Application
{
    private static Application $instance;
    private Routes $routes;

    public function __construct()
    {
        self::$instance = $this;
        $this->initialize();
    }

    public static function getInstance(): Application
    {
        return self::$instance;
    }

    private function initialize(): void
    {
        // Load environment variables
        $this->loadEnvironment();


        $this->databaseConnection();
        
        // Start session
        $this->startSession();
        
        // Initialize routes
        $this->routes = new Routes();
    }

    private function loadEnvironment(): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

    }

    private function databaseConnection(): void
    {
        DatabaseORM::getInstance();
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

    public function renderView(string $view, array $params = []): string
    {
        return View::render($view, $params);
    }
} 