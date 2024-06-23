<?php
namespace App\Services;

use App\Entity\Cryptocurrency;
use App\Repository\CryptocurrencyRepository;
use App\Repository\WalletCryptoRepository;
use Doctrine\ORM\EntityManagerInterface;

class CryptocurrencyService
{
    private $cryptocurrencyRepository;
    private $walletCryptoRepository;
    private $em;

    public function __construct(CryptocurrencyRepository $cryptocurrencyRepository, WalletCryptoRepository $walletCryptoRepository, EntityManagerInterface $em)
    {
        $this->cryptocurrencyRepository = $cryptocurrencyRepository;
        $this->walletCryptoRepository = $walletCryptoRepository;
        $this->em = $em;
    }

    public function getAllCryptocurrencies()
    {
        return $this->cryptocurrencyRepository->findAll();
    }

    public function getWalletCryptocurrencies($wallet)
    {
       return $this->walletCryptoRepository->findBy(["wallet"=> $wallet]);
    }

    public function getCryptocurrencyNames()
    {
        $cryptocurrencies = $this->cryptocurrencyRepository->findAll();
        $listCrypto = [];

        foreach ($cryptocurrencies as $crypto) {
            $listCrypto[] = strtolower($crypto->getName());
        }

        return $listCrypto;
    }
    public function findCryptocurrency($id): ?Cryptocurrency
    {
        return $this->cryptocurrencyRepository->find($id);
    }

    public function updateWalletBalances($walletCryptoUser, $walletCryptoUserTo, $amount, $nameCrypto, $idWalletChoose, $idWalletTo)
    {
        
        if ($walletCryptoUser->getSolde() < $amount) {
            return false;
        } else {
            $walletCryptoUser->setSolde($walletCryptoUser->getSolde() - $amount);
            $this->em->persist($walletCryptoUser);
            $this->em->flush();
            $walletCryptoUserTo->setSolde($walletCryptoUserTo->getSolde() + $amount);
            $this->em->persist($walletCryptoUserTo);
            $this->em->flush();
        }
        return true;
    }   
}
    
