<?php
declare(strict_types=1);

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use App\controllers\HomeController;
use App\controllers\AuthController;

//create a router
$router = new RouteCollector();

//define route
$router->get('/', [HomeController::class, 'showHomePage']);
$router->get('/register', [AuthController::class, 'showRegistrationFrom']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/signin', [AuthController::class, 'signin']);
$router->get('/about', [HomeController::class, 'about']);

//dispatch the req
$dispatcher = new Dispatcher($router->getData());

try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    echo $response;
} catch (HttpRouteNotFoundException $e) {
    http_response_code(404);
    echo "404 - Page not found <br>";
}
