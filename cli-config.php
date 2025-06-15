<?php

require 'vendor/autoload.php';

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;

$config = new PhpFile('migrations.php');

$entityManager = \App\Core\Db\DatabaseORM::getInstance();

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));