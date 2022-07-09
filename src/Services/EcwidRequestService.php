<?php

namespace LigaLazdinaPortfolio\Services;

use GuzzleHttp\Client;

class EcwidRequestService
{
    private const STORE_ID = 72527999;

    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client(['base_uri' => 'https://app.ecwid.com/api/v3/' . self::STORE_ID . '/']);
    }

    public function get(string $endpoint): object
    {
        $token = $_ENV['ECWID_PRIVATE_KEY'];

        $response = $this->httpClient->get($endpoint, [
            'headers' => ['Authorization' => 'Bearer ' . $token],
        ]);

        $contents = $response->getBody()->getContents();

        return json_decode($contents);
    }
}