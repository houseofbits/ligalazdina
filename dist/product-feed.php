<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();

use LigaLazdinaPortfolio\Helpers\Application;
use LigaLazdinaPortfolio\Repositories\ProductRepository;
use LigaLazdinaPortfolio\Services\GoogleFeedBuilder;

/** @var ProductRepository $repository */
$repository = Application::get(ProductRepository::class);
/** @var GoogleFeedBuilder $feedBuilder */
$feedBuilder = Application::get(GoogleFeedBuilder::class);

$products = $repository->findAll();

header("Content-type: text/xml");
echo $feedBuilder->buildFeed($products)->build();

