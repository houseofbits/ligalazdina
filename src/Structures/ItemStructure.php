<?php

namespace LigaLazdinaPortfolio\Structures;

class ItemStructure
{
    public string $itemId;
    public string $variantId;
    public string $url;
    public string $imageUrl;
    public string $title;
    public string $description;
    public string $price;
    public int $googleProductCategory;
    public ?string $color;
    public ?string $size;
    public ?string $ageGroup;
    public ?string $gender;
    public bool $isEnabled;

    public function isVariation(): bool
    {
        return $this->itemId !== $this->variantId;
    }
}