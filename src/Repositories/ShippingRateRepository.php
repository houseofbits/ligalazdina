<?php

namespace LigaLazdinaPortfolio\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use LigaLazdinaPortfolio\Entities\ShippingRate;
use LigaLazdinaPortfolio\Services\EntityManagerInstance;

class ShippingRateRepository extends EntityRepository
{
    public function __construct(EntityManagerInstance $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(ShippingRate::class));
    }

    public function removeAll(): void
    {
        $this->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->execute();

        $this->getEntityManager()->flush();
    }

    public function findRate(int $productType, int $zone): ?ShippingRate
    {
        return $this->findOneBy(['productType' => $productType, 'zone' => $zone]);
    }
}