<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;

// Create and run the application
$app = new Application();
$app->run();
