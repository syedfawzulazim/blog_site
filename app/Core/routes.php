<?php
declare(strict_types=1);

namespace App\Core;

use App\Controllers\BlogController;
use App\Core\DI\Container;
use App\Middleware\AuthMiddleware;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use App\Controllers\HomeController;
use App\Controllers\AuthController;

class Routes
{
    private RouteCollector $router;
    private Dispatcher $dispatcher;
    private Container $container;

    public function __construct()
    {
        $this->container = Application::getInstance()->getContainer();
        $this->router = new RouteCollector();
        $this->registerRoutes();
        $resolver = new PhrouteHandlerResolver($this->container);
        $this->dispatcher = new Dispatcher($this->router->getData(), $resolver);
    }

    private function registerRoutes(): void
    {
        $this->router->filter('auth', function() {
            return (new AuthMiddleware)->handle();
        });

        // Public routes
        $this->router->get('/', [HomeController::class, 'index']);

        // Auth routes
        $this->router->get('/register', [AuthController::class, 'showRegistrationForm']);
        $this->router->post('/register', [AuthController::class, 'register']);
        $this->router->get('/signin', [AuthController::class, 'showSignInForm']);
        $this->router->post('/signin', [AuthController::class, 'signIn']);
        $this->router->get('/logout', [AuthController::class, 'logout']);

        // Protected routes
        $this->router->group(['before' => 'auth'], function($router) {
            $router->get('/blog/create', [BlogController::class, 'index']);
            $router->post('/blog/create', [BlogController::class, 'create']);
            $router->get('/blog/edit/{id:\d+}', [BlogController::class, 'edit']);
            $router->post('/blog/edit/{id:\d+}', [BlogController::class, 'update']);
            $router->get('/blog/delete/{id:\d+}', [BlogController::class, 'delete']);
        });
    }

    public function dispatch(): void
    {
        try {
            $response = $this->dispatcher->dispatch(
                $_SERVER['REQUEST_METHOD'],
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );
            echo $response;
        } catch (HttpRouteNotFoundException $e) {
            $this->handleNotFound();
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    private function handleNotFound(): void
    {
        http_response_code(404);
        echo (new View)->render('error/404');
    }

    private function handleError(\Exception $e): void
    {   echo $e->getMessage();
        http_response_code(500);
        echo (new View)->render('error/500');
    }
}
