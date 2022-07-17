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
     * @ORM\Column(type="integer")
     */
    protected int $zone;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $minTransitTime;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $maxTransitTime;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $price;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $extraPrice;

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

    public function setZone(int $zone): ShippingRate
    {
        $this->zone = $zone;
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

    public function setPrice(int $price): ShippingRate
    {
        $this->price = $price;
        return $this;
    }

    public function setExtraPrice(int $extraPrice): ShippingRate
    {
        $this->extraPrice = $extraPrice;
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

    public function getZone(): int
    {
        return $this->zone;
    }

    public function getMinTransitTime(): int
    {
        return $this->minTransitTime;
    }

    public function getMaxTransitTime(): int
    {
        return $this->maxTransitTime;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getExtraPrice(): int
    {
        return $this->extraPrice;
    }
}