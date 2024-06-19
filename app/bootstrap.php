<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$connection = array(
    "driver" => "mysql",
    "user" => "root",
    "password" => "passbd",
    "host" => "127.0.0.1",
    "port" => 3306,
    "dbname" => "oasu"
);

$config = ORMSetup::createAttributeMetadataConfiguration(array("app/", false));
$entityManager = EntityManager::create($connection, $config);

function getEntityManager($entityManager) {
    return $entityManager;
}