<?php

namespace LigaLazdinaPortfolio\Services;

class ShippingZoneMapper
{
    public const ZONE_US = 1;
    public const ZONE_EUROPE = 2;
    public const ZONE_UK = 3;
    public const ZONE_CANADA = 4;

    public function getZoneFromCountryCode(string $countryCode): ?int
    {


        return null;
    }

    public function getCountryCodesForZone(int $zone): array
    {
        switch ($zone) {
            case self::ZONE_US:
                return ['US'];
        }

        return [];
    }
}