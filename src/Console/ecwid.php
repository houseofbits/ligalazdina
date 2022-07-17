<?php
require './vendor/autoload.php';

use LigaLazdinaPortfolio\Services\EcwidConsoleRunner;
use LigaLazdinaPortfolio\Helpers\Application;

(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->safeLoad();

/** @var EcwidConsoleRunner $ecwidConsole */
$ecwidConsole = Application::get(EcwidConsoleRunner::class);
$ecwidConsole->run($argv);
