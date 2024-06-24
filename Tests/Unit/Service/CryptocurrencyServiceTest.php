<?php

use PHPUnit\Framework\TestCase;
use App\Services\CryptocurrencyService;
use App\Entity\Cryptocurrency;
use App\Repository\CryptocurrencyRepository;
use App\Repository\WalletCryptoRepository;
use Doctrine\ORM\EntityManagerInterface;

class CryptocurrencyServiceTest extends TestCase
{
    private $cryptocurrencyService;

    private $cryptocurrencyRepository;

    private $walletCryptoRepository;
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cryptocurrencyRepository = $this->createMock(CryptocurrencyRepository::class);
        $this->walletCryptoRepository = $this->createMock(WalletCryptoRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->cryptocurrencyService = new CryptocurrencyService(
            $this->cryptocurrencyRepository,
            $this->walletCryptoRepository,
            $this->entityManager
        );
    }

    public function testGetAllCryptocurrencies(): void
    {
        $mockedCryptocurrencies = [
            new Cryptocurrency(),
            new Cryptocurrency(),
        ];

        $this->cryptocurrencyRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($mockedCryptocurrencies);

        $result = $this->cryptocurrencyService->getAllCryptocurrencies();
        $this->assertEquals($mockedCryptocurrencies, $result);
    }

    public function testGetCryptocurrencyNames(): void
    {
        $mockedCryptocurrencies = [
            (new Cryptocurrency())->setName('Bitcoin'),
            (new Cryptocurrency())->setName('Ethereum'),
        ];
        $this->cryptocurrencyRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($mockedCryptocurrencies);

        $result = $this->cryptocurrencyService->getCryptocurrencyNames();
        $this->assertEquals(['bitcoin', 'ethereum'], $result);
    }
}
