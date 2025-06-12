<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/core/init.php';

use App\core\db\DatabaseORM;
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
//$entityManager = DatabaseORM::create();
//echo 'index';
//echo $entityManager->isOpen();
