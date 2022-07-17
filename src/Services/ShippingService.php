<?php

namespace LigaLazdinaPortfolio\Services;

use Exception;
use LigaLazdinaPortfolio\Repositories\ShippingRateRepository;

class ShippingService
{
    private ShippingZoneMapper $shippingZoneMapper;
    private ShippingProductTypeMapper $shippingProductTypeMapper;
    private ShippingRateRepository $shippingRateRepository;

    public function __construct(ShippingZoneMapper        $shippingZoneMapper,
                                ShippingProductTypeMapper $shippingProductTypeMapper,
                                ShippingRateRepository $shippingRateRepository
    )
    {
        $this->shippingZoneMapper = $shippingZoneMapper;
        $this->shippingProductTypeMapper = $shippingProductTypeMapper;
        $this->shippingRateRepository = $shippingRateRepository;
    }

    public function calculateShipping(object $cartData): void
    {



    }

    /**
     * @throws Exception
     */
//    public function getShippingPrice(string $shippingProductTypeAttribute, ?string $sizeOption, string $destinationCountryCode): int
//    {
//        $zone = $this->shippingZoneMapper->getZoneFromCountryCode($destinationCountryCode);
//        $shippingProductType = $this->shippingProductTypeMapper->getShippingProductType($shippingProductTypeAttribute, $sizeOption);
//
//        $rate = $this->shippingRateRepository->findRate($shippingProductType, $zone);
//
//        //...
//
//        throw new Exception('Shipping rate not found');
//    }

}