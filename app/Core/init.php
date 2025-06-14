<?php

use Dotenv\Dotenv;

// load .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->safeLoad();

require_once 'routes.php';
require_once 'functions.php';
require_once 'db/DatabaseORM.php';