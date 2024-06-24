<?php

use PHPUnit\Framework\TestCase;
use App\Services\CoinGeckoService;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CoinGeckoServiceTest extends TestCase
{
    private $coinGeckoService;
    private $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->coinGeckoService = new CoinGeckoService($this->httpClient);
    }

    public function testGetMarketData(): void
    {
        $fakeResponse = [
            [
                'id' => 'bitcoin',
                'name' => 'Bitcoin',
                'current_price' => 35000.56,
            ],
            [
                'id' => 'ethereum',
                'name' => 'Ethereum',
                'current_price' => 2300.12,
            ],
        ];

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'https://api.coingecko.com/api/v3/coins/markets', [
                'headers' => [
                    'accept' => 'application/json',
                    'x-cg-demo-api-key' => 'CG-Z584fmyJiwnJAALN5QRjBNt8',
                ],
                'query' => [
                    'vs_currency' => 'usd',
                    'ids' => '',
                    'order' => 'market_cap_desc',
                    'per_page' => 100,
                    'page' => 1,
                    'sparkline' => 'true',
                ],
            ])
            ->willReturn($this->createMockResponse($fakeResponse));

        $result = $this->coinGeckoService->getMarketData();
        $this->assertEquals($fakeResponse, $result);
    }

    private function createMockResponse(array $data): ResponseInterface
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);
        $response->expects($this->any())
            ->method('toArray')
            ->willReturn($data);
        return $response;
    }
}
