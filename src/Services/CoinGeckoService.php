<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoinGeckoService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getPrices(array $ids, string $vsCurrency = 'eur'): array
    {
        $idsString = implode(',', $ids);
        $response = $this->client->request(
            'GET',
            "https://api.coingecko.com/api/v3/simple/price",
            [
                'query' => [
                    'ids' => $idsString,
                    'vs_currencies' => $vsCurrency,
                ],
            ]
        );

        return $response->toArray();
    }
}
