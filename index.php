<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use App\core\Database;

$pdo = Database::getInstance()->getConnection();
