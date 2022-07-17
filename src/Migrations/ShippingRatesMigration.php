<?php

namespace LigaLazdinaPortfolio\Migrations;

use LigaLazdinaPortfolio\Entities\ShippingRate;
use LigaLazdinaPortfolio\Services\EntityManagerInstance;
use LigaLazdinaPortfolio\Services\ShippingZoneMapper;
use LigaLazdinaPortfolio\Services\ShippingProductTypeMapper;

class ShippingRatesMigration
{
    private EntityManagerInstance $entityManager;

    private const RATES = [
        ShippingZoneMapper::ZONE_US => [
            ShippingProductTypeMapper::TYPE_POSTCARD => [359, 5, 3, 6],
            ShippingProductTypeMapper::TYPE_CANVAS_SM => [929, 400, 3, 6],
            ShippingProductTypeMapper::TYPE_CANVAS_MD => [1239, 440, 3, 6],
            ShippingProductTypeMapper::TYPE_FRAMED_POSTER_SM => [929, 400, 3, 6],
            ShippingProductTypeMapper::TYPE_FRAMED_POSTER_MD => [1239, 440, 3, 6],
            ShippingProductTypeMapper::TYPE_POSTER_SM => [439, 40, 3, 6],
            ShippingProductTypeMapper::TYPE_LAPTOP_SLEEVE => [709, 220, 3, 6],
            ShippingProductTypeMapper::TYPE_TOTE_BAG => [359, 180, 3, 6],
        ],
    ];

    public function __construct(EntityManagerInstance $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Throwable
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function migrate(): void
    {
        $this->entityManager->wrapInTransaction(function () {

            foreach (self::RATES as $zone => $productTypes) {
                foreach ($productTypes as $type => $rateData) {
                    $rate = new ShippingRate();

                    $rate->setZone($zone)
                        ->setProductType($type)
                        ->setPrice($rateData[0])
                        ->setExtraPrice($rateData[1])
                        ->setMinTransitTime($rateData[2])
                        ->setMaxTransitTime($rateData[3]);

                    $this->entityManager->persist($rate);
                }
            }
        });

        $this->entityManager->flush();
    }
}