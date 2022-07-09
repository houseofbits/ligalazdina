<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();

use LigaLazdinaPortfolio\Services\ProductFeedRepository;

$itemId = $_GET['itemId'] ?? null;

$repository = new ProductFeedRepository();
$products = $repository->listProducts($itemId);


foreach ($products as $product) {

    echo "<div style='display: flex; flex-direction: row; margin-bottom:12px;'>";
    echo "<img src='{$product->imageUrl}' width='300px' style='margin-right:12px;'>";
    echo "<div>
        <div><h4>{$product->title}</h4></div>
        <div><strong>ItemId: </strong>{$product->itemId}</div>
        <div><strong>VariantId: </strong>{$product->variantId}</div>
        <div><strong>Size, Color: </strong>{$product->size} {$product->color}</div>
        <div><strong>Price: </strong>{$product->price}</div>
        <div><strong>Google product category: </strong>{$product->googleProductCategory}</div>
        <div><a href='{$product->url}'>{$product->url}</a></div>
        </div>";
    echo "</div>";
}
?>
