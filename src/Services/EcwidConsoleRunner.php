<?php

namespace LigaLazdinaPortfolio\Services;

use LigaLazdinaPortfolio\Helpers\Console;
use LigaLazdinaPortfolio\Repositories\ProductRepository;

class EcwidConsoleRunner extends ConsoleRunner
{
    private EcwidProductImportService $importService;
    private ProductRepository $repository;

    public function __construct(EcwidProductImportService $importService,
                                ProductRepository         $repository
    )
    {
        $this->importService = $importService;
        $this->repository = $repository;
    }

    public function help()
    {
        Console::printLn("- dry-import [ECWID-Product-Id]");
        Console::printLn("- import-products [ECWID-Product-Id]");
        Console::printLn("- list-product");
        Console::printLn("- clear-products");
    }

    public function dryImport(?string $ecwidProductId = null): void
    {
        if ($ecwidProductId) {
            $products = $this->importService->fetchProductVariationsByEcwidId($ecwidProductId);
        } else {
            $products = $this->importService->fetchAll();
        }
    }

    public function importProducts(?string $ecwidProductId = null): void
    {
        if ($ecwidProductId) {
            $this->importService->importProductVariationsByEcwidId($ecwidProductId);
        } else {
            $this->importService->importAll();
        }
    }

    public function listProducts(): void
    {
        $products = $this->repository->findAll();
        Console::printLn(count($products) . " products", 's');
    }

    public function clearProducts(): void
    {
        $this->repository->removeAll();
        Console::printLn('Done', 's');
    }


}