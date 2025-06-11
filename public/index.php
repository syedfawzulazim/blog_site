<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/core/init.php';

use App\core\db\DatabasePDO as Database;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

//PDO-Database

//$dbh = Database::getInstance()->getConnection();
//$stmt= $dbh->prepare('select * from users where id = :id');
//$stmt->execute([':id' => 2]);
//
//while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//    show('Data', $row);
//}




//ORM-Database
//$config = ORMSetup::createAttributeMetadataConfiguration(
//    paths: [__DIR__ . '/../app/core/db/entity'],
//    isDevMode: true,
//);
//
//$dbParams = [
//    'dbname'   => $_ENV['DB_NAME'],
//    'user'     => $_ENV['DB_USER'],
//    'password' => $_ENV['DB_PASS'],
//    'host'     => $_ENV['DB_HOST'],
//    'driver'   =>  $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
//];
//
//$connection = DriverManager::getConnection($dbParams, $config);
//
//$entityManager = new EntityManager($connection, $config);
