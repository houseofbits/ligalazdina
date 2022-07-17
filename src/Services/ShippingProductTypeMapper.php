<?php

namespace LigaLazdinaPortfolio\Services;

use Exception;

class ShippingProductTypeMapper
{
    public const TYPE_POSTCARD = 1;
    public const TYPE_CANVAS_SM = 2;
    public const TYPE_CANVAS_MD = 3;
    public const TYPE_FRAMED_POSTER_SM = 4;
    public const TYPE_FRAMED_POSTER_MD = 5;
    public const TYPE_POSTER_SM = 7;
    public const TYPE_LAPTOP_SLEEVE = 8;
    public const TYPE_TOTE_BAG = 9;

    private const ATTRIBUTE_MAP = [
        'postcard' => self::TYPE_POSTCARD,
        'toteBag' => self::TYPE_TOTE_BAG,
        'laptopSleeve' => self::TYPE_LAPTOP_SLEEVE,
    ];

    private const ATTRIBUTES_WITH_SIZE_OPTION = [
        'canvas' => [
            '12x16 in.' => self::TYPE_CANVAS_SM,
            '16x20 in.' => self::TYPE_CANVAS_MD,
        ],
        'framedPoster' => [
            '12×16' => self::TYPE_FRAMED_POSTER_SM,
            '14×14' => self::TYPE_FRAMED_POSTER_SM,
            '16×16' => self::TYPE_FRAMED_POSTER_SM,
            '16×20' => self::TYPE_FRAMED_POSTER_MD,
            '18×24' => self::TYPE_FRAMED_POSTER_MD,
            '18×18' => self::TYPE_FRAMED_POSTER_MD,
        ],
        'poster' => [
            '12×16' => self::TYPE_POSTER_SM,
            '16×20' => self::TYPE_POSTER_SM,
            '18×24' => self::TYPE_POSTER_SM,
            '12×12' => self::TYPE_POSTER_SM,
            '16×16' => self::TYPE_POSTER_SM,
            '18×18' => self::TYPE_POSTER_SM,
        ],
    ];

    /**
     * @throws Exception
     */
    public function getShippingProductType(string $typeAttribute, ?string $sizeOption): int
    {
        if (isset(self::ATTRIBUTE_MAP[$typeAttribute])) {
            return self::ATTRIBUTE_MAP[$typeAttribute];
        }

        if (isset(self::ATTRIBUTES_WITH_SIZE_OPTION[$typeAttribute]) && !$sizeOption) {
            throw new Exception("Size option is required for product type");
        }

        if (isset(self::ATTRIBUTES_WITH_SIZE_OPTION[$typeAttribute][$sizeOption])) {
            return self::ATTRIBUTES_WITH_SIZE_OPTION[$typeAttribute][$sizeOption];
        }

        throw new Exception("Undefined product type attribute " . $typeAttribute);
    }

    /**
     * @throws Exception
     */
    public function validateProductData(string $typeAttribute, array $options): void
    {
        if (isset(self::ATTRIBUTE_MAP[$typeAttribute])) {
            return;
        }

        if (!isset(self::ATTRIBUTES_WITH_SIZE_OPTION[$typeAttribute])) {
            throw new Exception("Unrecognized product type attribute " . $typeAttribute);
        }

        $sizeOptions = [];
        foreach ($options as $option) {
            if (strtoupper($option->name) === 'SIZE') {
                $sizeOptions = $option->choices;
            }
        }

        if (empty($sizeOptions)) {
            throw new Exception("Missing option values");
        }

        foreach ($sizeOptions as $sizeOption) {
            if (!isset(self::ATTRIBUTES_WITH_SIZE_OPTION[$typeAttribute][$sizeOption->text])) {
                throw new Exception("Unrecognized option value '" . $sizeOption->text . "' for product type " . $typeAttribute);
            }
        }
    }
}