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

    public function getMarketData(string $vsCurrency = 'usd', array $ids = [], int $perPage = 100, int $page = 1)
    {
        $url = 'https://api.coingecko.com/api/v3/coins/markets';
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'accept' => 'application/json',
                'x-cg-demo-api-key' => 'CG-Z584fmyJiwnJAALN5QRjBNt8',
              ],
            'query' => [
                'vs_currency' => $vsCurrency,
                'ids' => implode(',', $ids),
                'order' => 'market_cap_desc',
                'per_page' => $perPage,
                'page' => $page,
                'sparkline' => 'true'
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to retrieve data from CoinGecko API');
        }

        return $response->toArray();
    }
}
