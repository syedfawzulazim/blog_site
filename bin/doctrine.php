#!/usr/bin/php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Db\DatabaseORM;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

$entityManager = DatabaseORM::getInstance();

$commands = [
    // If you want to add your own custom console commands,
    // you can do so here.
];

ConsoleRunner::run(
    new SingleManagerProvider($entityManager),
    $commands
);