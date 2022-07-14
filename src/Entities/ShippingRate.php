<?php

namespace LigaLazdinaPortfolio\Entities;

use Doctrine\ORM\Mapping as ORM;
use LigaLazdinaPortfolio\Entities\Traits\TimestampableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="shipping_rates")
 */
class ShippingRate
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $productType;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected string $country;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $minTransitTime;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $maxTransitTime;

    /**
     * @ORM\Column(type="string", length=60)
     */
    protected string $price;

    public function setId(int $id): ShippingRate
    {
        $this->id = $id;
        return $this;
    }

    public function setProductType(int $productType): ShippingRate
    {
        $this->productType = $productType;
        return $this;
    }

    public function setCountry(string $country): ShippingRate
    {
        $this->country = $country;
        return $this;
    }

    public function setMinTransitTime(int $minTransitTime): ShippingRate
    {
        $this->minTransitTime = $minTransitTime;
        return $this;
    }

    public function setMaxTransitTime(int $maxTransitTime): ShippingRate
    {
        $this->maxTransitTime = $maxTransitTime;
        return $this;
    }

    public function setPrice(string $price): ShippingRate
    {
        $this->price = $price;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductType(): int
    {
        return $this->productType;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getMinTransitTime(): int
    {
        return $this->minTransitTime;
    }

    public function getMaxTransitTime(): int
    {
        return $this->maxTransitTime;
    }

    public function getPrice(): string
    {
        return $this->price;
    }
}