<?php

namespace LigaLazdinaPortfolio\Services;

use LigaLazdinaPortfolio\Entities\Product;
use LigaLazdinaPortfolio\Entities\ShippingRate;
use LigaLazdinaPortfolio\Helpers\Console;
use LigaLazdinaPortfolio\Repositories\ProductRepository;
use LigaLazdinaPortfolio\Repositories\ShippingRateRepository;

class ShippingRateImportService
{
    private PrintfulService $printfulService;
    private ShippingRateRepository $shippingRateRepository;
    private ProductRepository $repository;
    private ShippingZoneMapper $shippingZoneMapper;

    public function __construct(PrintfulService        $printfulService,
                                ShippingRateRepository $shippingRateRepository,
                                ProductRepository      $repository,
                                ShippingZoneMapper     $shippingZoneMapper)
    {
        $this->printfulService = $printfulService;
        $this->shippingRateRepository = $shippingRateRepository;
        $this->repository = $repository;
        $this->shippingZoneMapper = $shippingZoneMapper;
    }

    public function importRates(int $zone, ?string $sku = null): void
    {
        $products = [];
        if ($sku) {
            $product = $this->repository->findBySku($sku);
            if ($product) {
                $products = [$product];
            }
        } else {
            $products = $this->repository->findAll();
        }

        $totalProducts = count($products);
        $index = 1;
        /** @var Product $product */
        foreach ($products as $product) {

            $rateData = $this->printfulService->getShippingRate(
                $product->getPrintfulVariantId(),
                $product->getPrice(),
                $this->shippingZoneMapper->getCountryCodeForZone($zone),
                $this->shippingZoneMapper->getStateCodeForZone($zone));

            $rate = $this->createShippingRateEntity($product->getPrintfulVariantId(), $zone, $rateData[0]);
            $this->shippingRateRepository->persist($rate);

            Console::printLn("Rate imported for ".$product->getSku(). " ({$index} of {$totalProducts}) ", 's');
            $index++;
        }
    }

    private function createShippingRateEntity(string $variantId, int $zone, array $data): ShippingRate
    {
        $rate = new ShippingRate();
        $rate->setPrintfulVariantId($variantId);
        $rate->setZone($zone);
        $rate->setMinTransitTime($data['minDeliveryDays']);
        $rate->setMaxTransitTime($data['maxDeliveryDays']);
        $rate->setPrice(round($data['rate'] * 100));

        return $rate;
    }
}