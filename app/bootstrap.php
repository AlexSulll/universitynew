<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;


function getEntityManager(): EntityManager
{
    $paths = array(__DIR__ . "/Entities");

    $connection = array(
        "driver" => "pdo_mysql",
        "host" => "127.0.0.1",
        "dbname" => "oasu",
        "user" => "root",
        "password" => "passbd",
        "port" => 3306
    );

    $config = Setup::createAttributeMetadataConfiguration($paths, true);
    return EntityManager::create($connection, $config);
}

function sendFail(string $message): void
{
    echo json_encode($message);
    die();
}