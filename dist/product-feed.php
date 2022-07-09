<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();

use LigaLazdinaPortfolio\Services\GoogleFeedBuilder;
use LigaLazdinaPortfolio\Services\ProductFeedRepository;

$repository = new ProductFeedRepository();
$products = $repository->listProducts();

$feedBuilder = new GoogleFeedBuilder();

header("Content-type: text/xml");
echo $feedBuilder->buildFeed($products)->build();

