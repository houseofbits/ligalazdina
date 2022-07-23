<?php

namespace LigaLazdinaPortfolio\Services;

use Exception;
use LigaLazdinaPortfolio\Entities\Product;
use LigaLazdinaPortfolio\Entities\ShippingRate;
use LigaLazdinaPortfolio\Helpers\Formatter;
use LigaLazdinaPortfolio\Repositories\ShippingRateRepository;
use Vitalybaev\GoogleMerchant\Exception\InvalidArgumentException;
use Vitalybaev\GoogleMerchant\Feed;
use Vitalybaev\GoogleMerchant\Product as FeedProduct;
use Vitalybaev\GoogleMerchant\Product\Availability\Availability;
use Vitalybaev\GoogleMerchant\Product\Shipping;

class GoogleFeedBuilder
{
    private ShippingRateRepository $shippingRateRepository;
    private ShippingZoneMapper $zoneMapper;

    public function __construct(ShippingRateRepository $shippingRateRepository,
                                ShippingZoneMapper     $zoneMapper)
    {
        $this->shippingRateRepository = $shippingRateRepository;
        $this->zoneMapper = $zoneMapper;
    }

    /**
     * @param Product[] $products
     * @return Feed
     */
    public function buildFeed(array $products): Feed
    {
        $feed = new Feed("Liga Lazdina Store", "https://store.ligalazdina.com", "Liga Lazdina Store");

        foreach ($products as $product) {
            $feedProduct = $this->buildFromProduct($product);
            $feed->addProduct($feedProduct);
        }

        return $feed;
    }

    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function buildFromProduct(Product $product): FeedProduct
    {
        $feedProduct = new FeedProduct();

        $feedProduct->setId($product->getSku());
        $feedProduct->setTitle($product->getTitle());
        $feedProduct->setDescription($product->getDescription());
        $feedProduct->setLink($product->getStoreUrl());
        $feedProduct->setImage($product->getImageUrl());
        $feedProduct->setAvailability(Availability::IN_STOCK);
        $feedProduct->setPrice($product->getFormattedPrice());
        $feedProduct->setGoogleCategory($product->getGoogleProductCategoryId());
        $feedProduct->setCondition('new');
        $feedProduct->setIdentifierExists('no');

        if ($product->isVariation()) {
            $feedProduct->addAttribute('item_group_id', $product->getGroupSku());
        }

        if ($product->getColor()) {
            $feedProduct->setColor($product->getColor());
        }

        if ($product->getSize()) {
            $feedProduct->setSize($product->getSize());
        }

        if ($product->getGender()) {
            $feedProduct->addAttribute('gender', $product->getGender());
        }

        if ($product->getAgeGroup()) {
            $feedProduct->addAttribute('age_group', $product->getAgeGroup());
        }

        $feedProduct->addAttribute('included_destination', 'Free_listings');
        $feedProduct->addAttribute('excluded_destination', 'Shopping_ads');

        $this->setShippingRates($feedProduct, $product->getPrintfulVariantId(), ShippingZoneMapper::ZONE_US);

        return $feedProduct;
    }

    /**
     * @throws Exception
     */
    private function setShippingRates(FeedProduct $feedProduct, string $printfulVariantId, int $zone): void
    {
        /** @var ShippingRate $rate */
        $rate = $this->shippingRateRepository->findRate($printfulVariantId, $zone);

        if (!$rate) {
            throw new Exception('Shipping rate not found for product');
        }

        $countryCode = $this->zoneMapper->getCountryCodeForZone($zone);
//
//        if (empty($countryCodes)) {
//            throw new Exception('No country codes found for zone');
//        }

        //foreach ($countryCodes as $countryCode) {
            $shipping = new Shipping();
            $shipping->setCountry($countryCode);
            $shipping->setPrice(Formatter::formattedPrice($rate->getPrice()));
            // ...

            $feedProduct->addShipping($shipping);
        //}
    }

}