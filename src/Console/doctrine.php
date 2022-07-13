<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use LigaLazdinaPortfolio\Services\EntityManagerInstance;

require './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->safeLoad();

$em = new EntityManagerInstance();

$helperSet = ConsoleRunner::createHelperSet($em);
ConsoleRunner::run($helperSet);
