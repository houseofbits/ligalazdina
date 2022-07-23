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
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected ?string $printfulVariantId = null;

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

    public function setId(int $id): ShippingRate
    {
        $this->id = $id;
        return $this;
    }

    public function setPrintfulVariantId(int $printfulVariantId): ShippingRate
    {
        $this->printfulVariantId = $printfulVariantId;
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

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrintfulVariantId(): int
    {
        return $this->printfulVariantId;
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
}