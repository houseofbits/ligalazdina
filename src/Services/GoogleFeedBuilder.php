<?php

namespace LigaLazdinaPortfolio\Services;

use LigaLazdinaPortfolio\Entities\Product;
use Vitalybaev\GoogleMerchant\Feed;
use Vitalybaev\GoogleMerchant\Product as FeedProduct;
use Vitalybaev\GoogleMerchant\Product\Availability\Availability;

class GoogleFeedBuilder
{
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

    public function buildFromProduct(Product $product): FeedProduct
    {
        $feedProduct = new FeedProduct();

        $feedProduct->setId($product->getSku());
        $feedProduct->setTitle($product->getTitle());
        $feedProduct->setDescription($product->getDescription());
        $feedProduct->setLink($product->getStoreUrl());
        $feedProduct->setImage($product->getImageUrl());
        $feedProduct->setAvailability(Availability::IN_STOCK);
        $feedProduct->setPrice($product->getPrice());
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

        return $feedProduct;
    }

}