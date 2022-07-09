<?php

namespace LigaLazdinaPortfolio\Services;

use Exception;
use LigaLazdinaPortfolio\Helpers\Console;

class EcwidProductImportService
{
    private EcwidRequestService $request;
    private ItemBuilder $itemBuilder;
    private ProductFeedRepository $repository;

    public function __construct()
    {
        $this->request = new EcwidRequestService();
        $this->itemBuilder = new ItemBuilder();
        $this->repository = new ProductFeedRepository();
    }

    public function fetchProducts(?string $productId): array
    {
        if ($productId) {
            $allProducts = [$this->request->get('products/' . $productId)];
        } else {
            $allProducts = $this->request->get('products');
            $allProducts = $allProducts->items ?? [];
        }

        Console::printLn(count($allProducts) . ' products fetched from Ecwid');

        $products = [];
        foreach ($allProducts as $productData) {
            $products = array_merge($products, $this->itemBuilder->buildItemWithOptions($productData));
        }

        Console::printLn(count($products) . ' products with variations created');

        return $products;
    }

    public function fetchProductsAndPersist(?string $productId): void
    {
        $products = $this->fetchProducts($productId);

        try {
            $this->repository->transaction(function () use ($products) {
                foreach ($products as $product) {
                    $this->repository->persistItem($product);
                }
            });
            Console::printLn(count($products) . ' products persisted', 's');
        } catch (Exception $exception) {
            Console::printLn('Failed to persisted product. ' . $exception->getMessage(), 'e');
        }
    }
}