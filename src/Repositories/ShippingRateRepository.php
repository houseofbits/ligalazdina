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

    public function findRate(string $printfulVariantId, int $zone): ?ShippingRate
    {
        return $this->findOneBy(['printfulVariantId' => $printfulVariantId, 'zone' => $zone]);
    }

    public function findRatesForProduct(string $printfulVariantId): array
    {
        return $this->findBy(['printfulVariantId' => $printfulVariantId]);
    }

    public function persist(ShippingRate $rate, bool $flush = true): void
    {
        $existingRate = $this->findRate($rate->getPrintfulVariantId(), $rate->getZone());

        if ($existingRate) {
            $rate->setId($existingRate->getId());
        }

        $this->getEntityManager()->merge($rate);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}