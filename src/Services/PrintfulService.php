<?php

namespace LigaLazdinaPortfolio\Services;

use Exception;
use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

class PrintfulService
{
    private array $productCache = [];

    private PrintfulApiClient $client;

    public function __construct()
    {
        $this->client = PrintfulApiClient::createOauthClient($_ENV['PF_ACCESS_KEY']);
    }

    /**
     * @throws Exception
     */
    public function getVariantId(string $productId, ?string $sizeOption, ?string $colorOption): ?int
    {
        try {

            if (isset($this->productCache[$productId])) {
                $product = $this->productCache[$productId];
            } else {
                $product = $this->client->get('products/' . $productId);
                $this->productCache[$productId] = $product;
            }

            //var_dump($product['variants']);

            if (empty($sizeOption) && empty($colorOption) && count($product['variants']) > 1) {
                throw new Exception('Option not defined for printful product with multiple variants');
            }

            if (empty($sizeOption) && empty($colorOption) && count($product['variants']) === 1) {
                return $product['variants'][0]['id'];
            }

            if ($sizeOption) {
                $sizeOption = $this->replaceSizeSpecialCharacters($sizeOption);
            }

            foreach ($product['variants'] as $variant) {
                if (!empty($sizeOption) && !empty($colorOption)
                    && $sizeOption == $this->replaceSizeSpecialCharacters($variant['size'])
                    && $colorOption == $variant['color']) {

                    return $variant['id'];
                } elseif (!empty($sizeOption)
                    && $sizeOption == $this->replaceSizeSpecialCharacters($variant['size'])) {

                    return $variant['id'];
                } elseif (!empty($colorOption)
                    && $colorOption == $variant['color']) {

                    return $variant['id'];
                }
            }

            throw new Exception('Variant not found for the product ' . implode(', ', [$sizeOption, $colorOption]));

        } catch (PrintfulApiException $e) {
            throw new Exception('Printful API Exception: ' . $e->getMessage() . " with " . $productId);
        } catch (PrintfulException $e) {
            throw new Exception('Printful Exception: ' . $e->getMessage() . " with " . $productId);
        }
    }

    function replaceSizeSpecialCharacters(string $text): string
    {
        $text = mb_ereg_replace('″', '', $text);
        $text = mb_ereg_replace('"', '', $text);
        $text = mb_ereg_replace('in.', '', $text);
        $text = mb_ereg_replace('in', '', $text);
        $text = mb_ereg_replace('×', 'x', $text);
        return trim($text);
    }

    public function getShippingRate(string $variantId, string $price, string $countryCode, ?string $state = null): array
    {
        try {
            $data = [
                "recipient" => [
                    "address1" => "",
                    "city" => "",
                    "country_code" => $countryCode,
                    "state" => $state
                ],
                "items" => [
                    [
                        "variant_id" => $variantId,
                        "quantity" => "1",
                        "value" => $price
                    ],
                ],
                "currency" => "EUR",
                "locale" => "en_US"
            ];

            return $this->client->post('shipping/rates', $data);

        } catch (PrintfulApiException $e) {
            throw new Exception('Printful API Exception: ' . $e->getMessage() . " with " . $variantId);
        } catch (PrintfulException $e) {
            throw new Exception('Printful Exception: ' . $e->getMessage() . " with " . $variantId);
        }
    }
}