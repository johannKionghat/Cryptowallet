<?php

use PHPUnit\Framework\TestCase;
use App\Services\CoinGeckoDataGraph;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;

class CoinGeckoDataGraphTest extends TestCase
{
    /** @var CoinGeckoDataGraph */
    private $coinGeckoDataGraph;
    private $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = $this->createMock(GuzzleClient::class);

        $this->coinGeckoDataGraph = new CoinGeckoDataGraph();
        $reflection = new \ReflectionClass($this->coinGeckoDataGraph);
        $clientProperty = $reflection->getProperty('client');
        $clientProperty->setAccessible(true);
        $clientProperty->setValue($this->coinGeckoDataGraph, $this->httpClient);
    }

    public function testGetMarketChart(): void
    {
        $fakeResponse = [
            'prices' => [
                [1000000000, 35000.56],
                [1000001000, 35200.12],
            ],
            'market_caps' => [
                [1000000000, 600000000000],
                [1000001000, 610000000000],
            ],
        ];
        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'coins/bitcoin/market_chart', [
                'headers' => [
                    'accept' => 'application/json',
                    'x-cg-demo-api-key' => 'CG-Z584fmyJiwnJAALN5QRjBNt8',
                ],
                'query' => [
                    'vs_currency' => 'usd',
                    'days' => 30,
                ],
            ])
            ->willReturn(new Response(200, [], json_encode($fakeResponse)));
        $result = $this->coinGeckoDataGraph->getMarketChart('bitcoin', 'usd', 30);
        $this->assertEquals($fakeResponse, $result);
    }
}
