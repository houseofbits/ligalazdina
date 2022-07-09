<?php

namespace LigaLazdinaPortfolio\Services;

use LigaLazdinaPortfolio\Structures\ItemOptionsStructure;
use LigaLazdinaPortfolio\Structures\ItemStructure;
use NumberFormatter;

class ItemBuilder
{
    private const CATEGORIES_WITH_PRODUCT_VARIANT_IMAGES = [
        130204436,  //Framed posters
        130243413, //Tote bags
        130262272, //Laptop sleeve
    ];

    private const CATEGORIES_WITH_ACCESSORIES = [
        130243413, //Tote bags
        130262272, //Laptop sleeve
    ];

    public function buildItemWithOptions(object $productData): array
    {
        $combinations = $this->getProductOptions($productData->options);
        if (!empty($combinations)) {
            $combinations = $this->cartesian($combinations);
            $result = [];
            foreach ($combinations as $index => $options) {
                $result[] = $this->buildItem($productData, $index, $options);
            }
            return $result;
        }

        return [$this->buildItem($productData)];
    }

    public function buildItem(object $productData, int $index = 0, array $options = []): ItemStructure
    {
        //echo json_encode($productData, JSON_PRETTY_PRINT);

        $optionIndexes = [];
        $optionValues = [];
        $priceModifier = 0;
        $color = null;
        $size = null;
        if (!empty($options)) {
            /** @var ItemOptionsStructure $optionValue */
            foreach ($options as $optionValue) {
                $priceModifier = $priceModifier + $optionValue->priceModifier;
                $optionIndexes[] = $optionValue->index;
                $optionValues[] = $optionValue->value;
                if (strtoupper($optionValue->option) === "SIZE") {
                    $size = $optionValue->value;
                }
                if (strtoupper($optionValue->option) === "COLOR") {
                    $color = $optionValue->value;
                }
            }
        }

        $item = new ItemStructure();

        $item->itemId = $productData->sku;
        $item->variantId = $this->createVariantId($productData->sku, $optionIndexes);
        $item->url = $this->createUrl($productData->url, $optionIndexes);
        $item->imageUrl = $productData->imageUrl;
        $item->title = $this->createTitle($productData->name, $productData->subtitle, $optionValues);
        $item->description = strip_tags($productData->description);
        $item->price = $this->createPrice($productData->price + $priceModifier, $productData->tax->defaultLocationIncludedTaxRate);
        $item->color = $color;
        $item->size = $size;
        $item->googleProductCategory = $productData->googleProductCategory;
        $item->isEnabled = $productData->enabled;
        $item->ageGroup = null;
        $item->gender = null;

        if ($this->shouldMatchImagesToVariants($productData->categoryIds)) {
            $item->imageUrl = $this->getVariantImageByOptionIndex($productData->media->images, $index) ?? $productData->imageUrl;
        }

        if ($this->isAccessory($productData->categoryIds)) {
            $item->ageGroup = 'adult';
            $item->gender = 'unisex';
        }

        return $item;
    }

    private function createPrice($price, $tax): string
    {
        $fmt = new NumberFormatter('de_DE', NumberFormatter::CURRENCY);

        $taxAmount = $price * $tax / 100;
        $total = $price + $taxAmount;

        return $fmt->formatCurrency($total, "EUR");
    }

    private function createVariantId(string $id, array $optionIndexes = []): string
    {
        $options = '';
        if (!empty($optionIndexes)) {
            $options = '-' . implode('-', $optionIndexes);
        }

        return $id . $options;
    }

    private function createTitle(string $title, string $subtitle, array $optionValues = []): string
    {
        $options = '';
        if (!empty($optionValues)) {
            $options = ', ' . implode(', ', $optionValues);
        }

        return $title . ' - ' . $subtitle . $options;
    }

    private function createUrl(string $url, array $optionsIndexes = []): string
    {
        $options = '';
        if (!empty($optionsIndexes)) {
            $options = '?options=' . implode(',', $optionsIndexes);
        }

        return $url . $options;
    }

    private function getProductOptions($options): array
    {
        $result = [];

        foreach ($options as $option) {
            $optionsResult = [];
            $index = 1;
            foreach ($option->choices as $choice) {
                $itemOption = new ItemOptionsStructure();

                $itemOption->index = $index;
                $itemOption->priceModifier = $choice->priceModifier;
                $itemOption->option = $option->name;
                $itemOption->value = $choice->text;

                $optionsResult[] = $itemOption;
                $index++;
            }
            $result[] = $optionsResult;
        }

        return $result;
    }

    private function cartesian($input)
    {
        $result = array(array());

        foreach ($input as $key => $values) {
            $append = array();

            foreach ($result as $product) {
                foreach ($values as $item) {
                    $product[$key] = $item;
                    $append[] = $product;
                }
            }

            $result = $append;
        }

        return $result;
    }

    private function shouldMatchImagesToVariants(array $categories): bool
    {
        return (bool)array_intersect($categories, self::CATEGORIES_WITH_PRODUCT_VARIANT_IMAGES);
    }

    private function isAccessory(array $categories): bool
    {
        return (bool)array_intersect($categories, self::CATEGORIES_WITH_ACCESSORIES);
    }

    private function getVariantImageByOptionIndex(array $images, int $index): ?string
    {
        if (isset($images[$index])) {
            return $images[$index]->image1500pxUrl;
        }

        return null;
    }
}