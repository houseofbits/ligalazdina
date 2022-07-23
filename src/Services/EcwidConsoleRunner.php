<?php

namespace LigaLazdinaPortfolio\Services;

use Doctrine\ORM\Tools\SchemaTool;
use LigaLazdinaPortfolio\Helpers\Application;
use LigaLazdinaPortfolio\Helpers\Console;
use LigaLazdinaPortfolio\Migrations\ShippingRatesMigration;
use LigaLazdinaPortfolio\Repositories\ProductRepository;
use LigaLazdinaPortfolio\Repositories\ShippingRateRepository;
use Printful\PrintfulApiClient;

class EcwidConsoleRunner extends ConsoleRunner
{
    private EcwidProductImportService $importService;
    private ProductRepository $repository;
    private ShippingRateRepository $shippingRateRepository;
    private EntityManagerInstance $entityManagerInstance;

    public function __construct(EcwidProductImportService $importService,
                                ProductRepository         $repository,
                                ShippingRateRepository    $shippingRateRepository,
                                EntityManagerInstance $entityManagerInstance
    )
    {
        $this->importService = $importService;
        $this->repository = $repository;
        $this->shippingRateRepository = $shippingRateRepository;
        $this->entityManagerInstance = $entityManagerInstance;
    }

    public function help()
    {
        Console::printLn("- dry-import [ECWID-Product-Id]");
        Console::printLn("- import-products [ECWID-Product-Id]");
        Console::printLn("- list-product");
        Console::printLn("- clear-products");
        Console::printLn("- pf-product-types");
        Console::printLn("- pf-products-by-type");
        Console::printLn("- pf-product-variants");
        Console::printLn("- pf-shipping [VariantId, Country]");
        Console::printLn("- pf-shipping [VariantId, Country]");
        Console::printLn("- import-shipping-rates");
        Console::printLn("- create-schema");
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

    public function migrateShippingRates(): void
    {
        $this->shippingRateRepository->removeAll();

        Application::get(ShippingRatesMigration::class)->migrate();

        Console::printLn('Done', 's');
    }

    /**
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulApiException
     */
    public function pfProductTypes(): void
    {
        $pf = new PrintfulApiClient($_ENV['PF_ACCESS_KEY']);

        $products = $pf->get('products');
        $types = array_unique(array_map(fn($product) => $product['type'], $products));

        foreach ($types as $type) {
            Console::printLn($type);
        }
    }

    /**
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulApiException
     */
    public function pfProductsByType(?string $type): void
    {
        $pf = new PrintfulApiClient($_ENV['PF_ACCESS_KEY']);
        $products = $pf->get('products');

        foreach ($products as $product) {
            if ($product['type'] === $type) {
                Console::printLn($product['id'] . " / " . $product['title']);
            }
        }
    }

    /**
     * @param string|null $productId
     * @return void
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     *
        3,Canvas (in)
        84,All-Over Print Tote
        171,Premium Luster Photo Paper Poster (in)
        172,Premium Luster Photo Paper Framed Poster (in)
        394,Laptop Sleeve
        433,Standard Postcard
        568,Greeting Card
     *
     */
    public function pfProductVariants(?string $productId): void
    {
        $pf = new PrintfulApiClient($_ENV['PF_ACCESS_KEY']);
        $product = $pf->get('products/' . $productId);

        foreach ($product['variants'] as $variant) {
            Console::printLn("Variant id: " . $variant['id'] . " / Name: " . $variant['name'] . " / Size: " . $variant['size']);
        }
    }

    public function pfShipping(?string $variantId, ?string $country = 'LV'): void
    {
        $pf = PrintfulApiClient::createOauthClient($_ENV['PF_ACCESS_KEY']);

        $data = [
            "recipient" => [
                "address1" => "",
                "city" => "",
                "country_code" => $country,
            ],
            "items" => [
                [
                    "variant_id" => $variantId,
                    "quantity" => "1",
                ],
            ],
            "currency" => "EUR",
            "locale" => "en_US"
        ];

        $rates = $pf->post('shipping/rates', $data);
        var_dump($rates);
    }

    public function importShippingRates(string $zone = '1', ?string $sku = null): void
    {
        /** @var ShippingRateImportService $importService */
        $importService = Application::get(ShippingRateImportService::class);

        $importService->importRates((int)$zone, $sku);
    }

    public function createSchema(): void
    {
        $tool = new SchemaTool($this->entityManagerInstance);
        $classes = array(
            $this->entityManagerInstance->getClassMetadata('LigaLazdinaPortfolio\Entities\Product'),
            $this->entityManagerInstance->getClassMetadata('LigaLazdinaPortfolio\Entities\ShippingRate')
        );
        $tool->updateSchema($classes);

        Console::printLn("Done", 's');
    }
}