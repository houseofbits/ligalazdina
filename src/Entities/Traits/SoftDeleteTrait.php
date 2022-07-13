<?php

namespace LigaLazdinaPortfolio\Entities\Traits;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

trait SoftDeleteTrait
{
    /**
     * @var ?DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true, options={"default": NULL})
     */
    private ?DateTime $deletedAt = null;

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setDeletedAt(?DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}