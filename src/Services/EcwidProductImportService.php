<?php

namespace LigaLazdinaPortfolio\Services;

use LigaLazdinaPortfolio\Entities\Product;
use LigaLazdinaPortfolio\Helpers\Console;
use LigaLazdinaPortfolio\Repositories\ProductRepository;

class EcwidProductImportService
{
    private EcwidRequestService $request;
    private ProductVariationsBuilder $productVariationsBuilder;
    private ProductRepository $repository;

    public function __construct(
        EcwidRequestService      $request,
        ProductVariationsBuilder $productVariationsBuilder,
        ProductRepository        $repository
    )
    {
        $this->request = $request;
        $this->productVariationsBuilder = $productVariationsBuilder;
        $this->repository = $repository;
    }

    /**
     * @return Product[]
     */
    public function fetchAll(): array
    {
        $allProducts = $this->request->get('products');
        $allProducts = $allProducts->items ?? [];

        Console::printLn(count($allProducts) . ' products fetched from Ecwid');

        $products = [];
        foreach ($allProducts as $productData) {
            $products = array_merge($products, $this->productVariationsBuilder->buildProductVariationsFromEcwidProduct($productData));
        }

        Console::printLn(count($products) . ' product variations generated');

        return $products;
    }

    /**
     * @return Product[]
     */
    public function fetchProductVariationsByEcwidId(string $ecwidProductId): array
    {
        $productData = $this->request->get('products/' . $ecwidProductId);

        if (!empty($productData)) {
            Console::printLn('1 product fetched from Ecwid');

            $products = $this->productVariationsBuilder->buildProductVariationsFromEcwidProduct($productData);

            Console::printLn(count($products) . ' product variations generated');

            return $products;
        }

        return [];
    }

    public function importAll(): void
    {
        $products = $this->fetchAll();

        if (!empty($products)) {
            $this->repository->persistAll($products);
        }
    }

    public function importProductVariationsByEcwidId(string $ecwidProductId): void
    {
        $products = $this->fetchProductVariationsByEcwidId($ecwidProductId);

        if (!empty($products)) {
            $this->repository->persistAll($products);
        }
    }
}