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
        foreach ($walletCryptoUser as $wcu) {
            if( $wcu->getNameCrypto() == $nameCrypto && $wcu->getWallet()->getId()==$idWalletChoose){
                if ($wcu->getSolde() < $amount) {
                    return false;
                } else {
                    $wcu->setSolde($wcu->getSolde() - $amount);
                    $this->em->persist($wcu);
                    $this->em->flush();
                }
            }
        }
        
        foreach ($walletCryptoUserTo as $wcu) {
            if( $wcu->getNameCrypto() == $nameCrypto && $wcu->getWallet()->getId()==$idWalletTo){
                $wcu->setSolde($wcu->getSolde() + $amount);
                $this->em->persist($wcu);
                $this->em->flush();
            }
        }
        return true;
    }
}
