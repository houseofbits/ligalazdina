<?php

namespace LigaLazdinaPortfolio\Services;

class ShippingZoneMapper
{
    public const ZONE_US = 1;
    public const ZONE_EUROPE = 2;
    public const ZONE_UK = 3;
    public const ZONE_CANADA = 4;

    public const ZONE_NAMES = [
        self::ZONE_US => "US",
        self::ZONE_EUROPE => "Europe",
        self::ZONE_UK => "United Kingdom",
        self::ZONE_CANADA => "Canada",
    ];

    public function getCountryCodeForZone(int $zone): string
    {
        switch ($zone) {
            case ShippingZoneMapper::ZONE_US:
                return 'US';
            case ShippingZoneMapper::ZONE_EUROPE:
                return 'LV';
        };

        return 'LV';
    }

    public function getStateCodeForZone(int $zone): ?string
    {
        switch ($zone) {
            case ShippingZoneMapper::ZONE_US:
                return 'NC';
        };

        return null;
    }
}