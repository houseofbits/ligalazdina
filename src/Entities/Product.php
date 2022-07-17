<?php

namespace LigaLazdinaPortfolio\Entities;

use Doctrine\ORM\Mapping as ORM;
use LigaLazdinaPortfolio\Entities\Traits\SoftDeleteTrait;
use LigaLazdinaPortfolio\Entities\Traits\TimestampableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
{
    use TimestampableTrait;
    use SoftDeleteTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $shippingProductType = null;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected string $sku;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected string $groupSku;

    /**
     * @ORM\Column(type="string")
     */
    protected string $storeUrl;

    /**
     * @ORM\Column(type="string")
     */
    protected string $imageUrl;

    /**
     * @ORM\Column(type="string")
     */
    protected string $title;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    protected string $description;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $price;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $color;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $size;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $googleProductCategoryId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $ageGroup;

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function setShippingProductType(int $shippingProductType): Product
    {
        $this->shippingProductType = $shippingProductType;
        return $this;
    }

    public function setSku(string $sku): Product
    {
        $this->sku = $sku;
        return $this;
    }

    public function setGroupSku(string $groupSku): Product
    {
        $this->groupSku = $groupSku;
        return $this;
    }

    public function setStoreUrl(string $storeUrl): Product
    {
        $this->storeUrl = $storeUrl;
        return $this;
    }

    public function setImageUrl(string $imageUrl): Product
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function setTitle(string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function setColor(?string $color): Product
    {
        $this->color = $color;
        return $this;
    }

    public function setSize(?string $size): Product
    {
        $this->size = $size;
        return $this;
    }

    public function setGoogleProductCategoryId(string $googleProductCategoryId): Product
    {
        $this->googleProductCategoryId = $googleProductCategoryId;
        return $this;
    }

    public function setGender(?string $gender): Product
    {
        $this->gender = $gender;
        return $this;
    }

    public function setAgeGroup(?string $ageGroup): Product
    {
        $this->ageGroup = $ageGroup;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getShippingProductType(): int
    {
        return $this->shippingProductType;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getGroupSku(): string
    {
        return $this->groupSku;
    }

    public function getStoreUrl(): string
    {
        return $this->storeUrl;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getGoogleProductCategoryId(): string
    {
        return $this->googleProductCategoryId;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getAgeGroup(): ?string
    {
        return $this->ageGroup;
    }

    public function isVariation(): bool
    {
        return $this->sku !== $this->groupSku;
    }
}