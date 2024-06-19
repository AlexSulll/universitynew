<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once "bootstrap.php";

$entityManager = getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);