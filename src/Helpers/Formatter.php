<?php

namespace LigaLazdinaPortfolio\Helpers;

use NumberFormatter;

class Formatter
{
    public static function formattedPrice(int $price): string
    {
        $fmt = new NumberFormatter('de_DE', NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($price / 100, "EUR");
    }
}