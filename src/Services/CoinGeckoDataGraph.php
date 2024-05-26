<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoinGeckoDataGraph
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.coingecko.com/api/v3/',
        ]);
    }

    public function getMarketChart(string $id, string $vsCurrency, int $days)
    {
        $response = $this->client->request('GET', "coins/{$id}/market_chart", [
            'headers' => [
                'accept' => 'application/json',
                'x-cg-demo-api-key' => 'CG-Z584fmyJiwnJAALN5QRjBNt8',
              ],
            'query' => [
                'vs_currency' => $vsCurrency,
                'days' => $days,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
