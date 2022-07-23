<?php

namespace LigaLazdinaPortfolio\Services;

use Exception;
use LigaLazdinaPortfolio\Entities\Product;
use LigaLazdinaPortfolio\Helpers\Console;
use LigaLazdinaPortfolio\Structures\ItemOptionsStructure;

class ProductVariationsBuilder
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

    private PrintfulService $printfulService;

    public function __construct(PrintfulService $printfulService)
    {
        $this->printfulService = $printfulService;
    }

    /**
     * @throws Exception
     */
    public function validateEcwidProduct(object $productData): void
    {
        if (empty($productData->googleProductCategory)) {
            throw new Exception("Missing googleProductCategory");
        }

        if (!is_array($productData->attributes)) {
            throw new Exception("Missing attributes");
        }

        if (!$this->getAttributeValue($productData->attributes, 'PrintfulProductId')) {
            throw new Exception("Missing PrintfulProductId attribute");
        }
    }

    /**
     * @param object $productData
     * @return Product[]
     */
    public function buildProductVariationsFromEcwidProduct(object $productData): array
    {
        try {
            $this->validateEcwidProduct($productData);

            $result = [];
            $combinations = $this->getProductOptions($productData->options);
            if (!empty($combinations)) {
                $combinations = $this->cartesian($combinations);
                foreach ($combinations as $index => $options) {
                    $result[] = $this->buildProduct($productData, $index, $options);
                }
            } else {
                $result = [$this->buildProduct($productData)];
            }

            return $result;
        } catch (Exception $e) {
            Console::printLn($productData->id . " | " . $e->getMessage(), 'e');
        }
        return [];
    }

    private function buildProduct(object $productData, int $index = 0, array $options = []): Product
    {
        $product = new Product();

        $price = $this->calculatePriceWithOptions($productData->price, $options);
        $printfulProductId = $this->getAttributeValue($productData->attributes, 'PrintfulProductId');

        $product->setSku($this->createVariantSku($productData->sku, $options))
            ->setGroupSku($productData->sku)
            ->setStoreUrl($this->createUrl($productData->url, $options))
            ->setImageUrl($productData->imageUrl)
            ->setTitle($this->createTitle($productData->name, $productData->subtitle, $options))
            ->setDescription(strip_tags($productData->description))
            ->setPrice($this->createPrice($price, $productData->tax->defaultLocationIncludedTaxRate))
            ->setColor($this->getOptionValue($options, 'color'))
            ->setSize($this->getOptionValue($options, 'size'))
            ->setGoogleProductCategoryId($productData->googleProductCategory)
            ->setAgeGroup(null)
            ->setGender(null);

        $printfulVariantId = $this->printfulService->getVariantId(
            $printfulProductId,
            $this->getOptionValue($options, 'size'),
            $this->getOptionValue($options, 'color')
        );
        $product->setPrintfulVariantId($printfulVariantId);

        if ($this->shouldMatchImagesToVariants($productData->categoryIds)) {
            $product->setImageUrl($this->getVariantImageByOptionIndex($productData->media->images, $index) ?? $productData->imageUrl);
        }

        if ($this->isAccessory($productData->categoryIds)) {
            $product->setAgeGroup('adult');
            $product->setGender('unisex');

            if (!$product->getColor()) {
                $product->setColor('Black');
            }
        }

        return $product;
    }

    /**
     * @param ItemOptionsStructure[] $options
     * @param string $optionName
     * @return string|null
     */
    private function getOptionValue(array $options, string $optionName): ?string
    {
        foreach ($options as $optionValue) {
            if (strtoupper($optionValue->option) === strtoupper($optionName)) {
                return $optionValue->value;
            }
        }
        return null;
    }

    /**
     * @param float $basePrice
     * @param ItemOptionsStructure[] $options
     * @return float
     */
    private function calculatePriceWithOptions(float $basePrice, array $options = []): float
    {
        if (!empty($options)) {
            return array_reduce($options, fn(float $acc, ItemOptionsStructure $optionsStructure) => $acc + $optionsStructure->priceModifier, $basePrice);
        }

        return $basePrice;
    }

    private function createPrice(float $price, float $tax): int
    {
        $taxAmount = $price * $tax / 100;
        return round(($price + $taxAmount) * 100);
    }

    /**
     * @param string $id
     * @param ItemOptionsStructure[] $options
     * @return string
     */
    private function createVariantSku(string $id, array $options = []): string
    {
        if (!empty($options)) {
            $indexes = array_map(fn(ItemOptionsStructure $option) => $option->index, $options);
            return $id . '-' . implode('-', $indexes);
        }

        return $id;
    }

    /**
     * @param string $title
     * @param string $subtitle
     * @param ItemOptionsStructure[] $options
     * @return string
     */
    private function createTitle(string $title, string $subtitle, array $options = []): string
    {
        if (!empty($options)) {
            $values = array_map(fn(ItemOptionsStructure $option) => $option->value, $options);
            return $title . ' - ' . $subtitle . ', ' . implode(', ', $values);
        }

        return $title . ' - ' . $subtitle;
    }

    /**
     * @param string $url
     * @param ItemOptionsStructure[] $options
     * @return string
     */
    private function createUrl(string $url, array $options = []): string
    {
        if (!empty($optionsIndexes)) {
            $indexes = array_map(fn(ItemOptionsStructure $option) => $option->index, $options);
            return $url . '?options=' . implode(',', $indexes);
        }

        return $url;
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

    private function getAttributeValue(array $attributes, string $name): ?string
    {
        foreach ($attributes as $attribute) {
            if ($attribute->name === $name) {
                return $attribute->value;
            }
        }

        return null;
    }
}