<?php
require './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->safeLoad();

//todo:
//  age_group attribute
//  investigate regarding shipping options

use LigaLazdinaPortfolio\Services\EcwidProductImportService;
use LigaLazdinaPortfolio\Services\ProductFeedRepository;

(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

if (!isset($argv[1])) {
    die('no args');
}

$command = strtolower($argv[1]);
$command = str_replace('-', '', ucwords($command, '-'));

if (function_exists($command)) {
    $command($argv[2] ?? null);
} else {
    die('command not recognized');
}

function help()
{
    echo "- dry-import [productId]\n";
    echo "- import [productId]\n";
    echo "- list-products [productId]\n";
    echo "- clean\n";
}

function dryImport(?string $productId)
{
    $importService = new EcwidProductImportService();
    $allProducts = $importService->fetchProducts($productId);

    foreach ($allProducts as $product) {
        echo json_encode($product, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

function import(?string $productId)
{
    $importService = new EcwidProductImportService();
    $importService->fetchProductsAndPersist($productId);
}

function listProducts(?string $productId)
{
    $repository = new ProductFeedRepository();
    $result = $repository->listProducts($productId);

    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function clean()
{
    $repository = new ProductFeedRepository();
    $repository->dropSchema();
    $repository->createSchema();
}
