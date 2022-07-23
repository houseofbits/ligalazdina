<?php

use LigaLazdinaPortfolio\Entities\Product;
use LigaLazdinaPortfolio\Entities\ShippingRate;
use LigaLazdinaPortfolio\Helpers\Application;
use LigaLazdinaPortfolio\Helpers\Formatter;
use LigaLazdinaPortfolio\Repositories\ProductRepository;
use LigaLazdinaPortfolio\Repositories\ShippingRateRepository;
use LigaLazdinaPortfolio\Services\ShippingZoneMapper;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();

$sku = $_GET['sku'] ?? null;

/** @var ProductRepository $repository */
$repository = Application::get(ProductRepository::class);
$shippingRateRepository = Application::get(ShippingRateRepository::class);

$products = [];
if ($sku) {
    $product = $repository->findBySku($sku);
    if ($product) {
        $products = [$product];
    }
} else {
    $products = $repository->findAll();
}

/** @var Product $product */
foreach ($products as $product) {

    $shippingRates = $shippingRateRepository->findRatesForProduct($product->getPrintfulVariantId());

    $price = Formatter::formattedPrice($product->getPrice());

    echo "<div style='display: flex; flex-direction: row; margin-bottom:12px;'>";
    echo "<img src='{$product->getImageUrl()}' width='300px' style='margin-right:12px;'>";
    echo "<div>
        <div><h4>{$product->getTitle()}</h4></div>
        <div><strong>SKU: </strong>{$product->getSku()}</div>
        <div><strong>Group SKU: </strong>{$product->getGroupSku()}</div>
        <div><strong>Size, Color: </strong>{$product->getSize()} {$product->getColor()}</div>
        <div><strong>Price: </strong>{$price}</div>
        <div><strong>Google product category: </strong>{$product->getGoogleProductCategoryId()}</div>
        <div><a href='{$product->getStoreUrl()}'>{$product->getStoreUrl()}</a></div>
        <div><strong>Printful variant id: </strong>{$product->getPrintfulVariantId()}</div>";
    echo "<table style='border: solid 1px gray; border-collapse: collapse;'>";

    /** @var ShippingRate $shippingRate */

    echo "<tr style='border: solid 1px gray;'>
            <th style='border: solid 1px gray; padding:0 6px;'>Zone</th>
            <th style='border: solid 1px gray; padding:0 6px;'>Price</th>
            <th style='border: solid 1px gray; padding:0 6px;'>Min shippig time</th>            
            <th style='border: solid 1px gray; padding:0 6px;'>Max shipping time</th>
          </tr>";
    foreach ($shippingRates as $shippingRate) {
        $shippingPrice = Formatter::formattedPrice($shippingRate->getPrice());
        $zoneName = ShippingZoneMapper::ZONE_NAMES[$shippingRate->getZone()];
        echo "<tr style='border: solid 1px gray;'>
            <td style='border: solid 1px gray; padding:0 6px;'>{$zoneName}</td>
            <td style='border: solid 1px gray; padding:0 6px;'>{$shippingPrice}</td>
            <td style='border: solid 1px gray; padding:0 6px;'>{$shippingRate->getMinTransitTime()} days</td>            
            <td style='border: solid 1px gray; padding:0 6px;'>{$shippingRate->getMaxTransitTime()} days</td>
          </tr>";
    }

    echo "</table>";
    echo "</div>";
    echo "</div>";
}
?>
