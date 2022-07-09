<?php

namespace LigaLazdinaPortfolio\Services;

use LigaLazdinaPortfolio\Structures\ItemStructure;
use Vitalybaev\GoogleMerchant\Feed;
use Vitalybaev\GoogleMerchant\Product;
use Vitalybaev\GoogleMerchant\Product\Availability\Availability;

class GoogleFeedBuilder
{
    public function buildFeed(array $items): Feed
    {
        $feed = new Feed("Liga Lazdina Store", "https://store.ligalazdina.com", "Liga Lazdina Store");

        $enabledItems = array_filter($items, fn(ItemStructure $item) => $item->isEnabled);

        foreach ($enabledItems as $item) {
            $product = $this->buildFromItem($item);
            $feed->addProduct($product);
        }

        return $feed;
    }

    public function buildFromItem(ItemStructure $item): Product
    {
        $product = new Product();

        $product->setId($item->variantId);
        $product->setTitle($item->title);
        $product->setDescription($item->description);
        $product->setLink($item->url);
        $product->setImage($item->imageUrl);
        $product->setAvailability(Availability::IN_STOCK);
        $product->setPrice($item->price);
        $product->setGoogleCategory($item->googleProductCategory);
        $product->setCondition('new');
        $product->setIdentifierExists('no');

        if ($item->isVariation()) {
            $product->addAttribute('item_group_id', $item->itemId);
        }

        if ($item->color) {
            $product->setColor($item->color);
        }

        if ($item->size) {
            $product->setSize($item->size);
        }

        if ($item->gender) {
            $product->addAttribute('gender', $item->gender);
        }

        if ($item->ageGroup) {
            $product->addAttribute('age_group', $item->ageGroup);
        }

        $product->addAttribute('included_destination', 'Free_listings');
        $product->addAttribute('excluded_destination', 'Shopping_ads');

        return $product;
    }

}