<?php

namespace LigaLazdinaPortfolio\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use LigaLazdinaPortfolio\Entities\Product;
use LigaLazdinaPortfolio\Services\EntityManagerInstance;

class ProductRepository extends EntityRepository
{
    public function __construct(EntityManagerInstance $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(Product::class));
    }

    public function persistAll(array $products): void
    {
        $this->getEntityManager()->wrapInTransaction(function () use ($products) {
            foreach ($products as $product) {
                $this->persist($product, false);
            }
        });

        $this->getEntityManager()->flush();
    }

    public function persist(Product $product, bool $flush = true): void
    {
        $existingProduct = $this->findOneBy(['sku' => $product->getSku()]);

        if ($existingProduct) {
            $product->setId($existingProduct->getId());
        }

        $this->getEntityManager()->merge($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySku(string $sku): ?Product
    {
        return $this->findOneBy(['sku' => $sku]);
    }

    public function findAll(): array
    {
        return $this->findBy(['deletedAt' => null]);
    }

    public function removeAll(): void
    {
        $this->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->execute();

        $this->getEntityManager()->flush();
    }
}