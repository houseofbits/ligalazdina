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
        Console::printLn("- import [ECWID-Product-Id]");
        Console::printLn("- list-product");
    }

    public function dryImport(?string $ecwidProductId = null): void
    {
        if ($ecwidProductId) {
            $products = $this->importService->fetchProductVariationsByEcwidId($ecwidProductId);
        } else {
            $products = $this->importService->fetchAll();
        }
    }

    public function import(?string $ecwidProductId = null): void
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
        var_dump(count($products));
    }


}