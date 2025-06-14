<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;

// Create and run the application
$app = new Application();
$app->run();


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