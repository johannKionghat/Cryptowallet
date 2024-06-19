<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Cryptocurrency;
use App\Entity\Wallet;
use App\Entity\WalletCrypto;
use App\Repository\CryptocurrencyRepository;
use App\Services\CoinGeckoService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture 
{
    private $passwordHasher;
    private $coinGeckoService;
    private $cryptocurrencyRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher, CoinGeckoService $coinGeckoService, CryptocurrencyRepository $cryptocurrencyRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->coinGeckoService = $coinGeckoService;
        $this->cryptocurrencyRepository = $cryptocurrencyRepository;
    }

    public function load(ObjectManager $manager)
    {
        // Create default admin user
        $admin = new User();
        $admin->setFirstname('admin');
        $admin->setLastname('admin');
        $admin->setEmail('admin@admin.test');
        $admin->setIsVerified(true);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setRoles([1]);
        $manager->persist($admin);
        $manager->flush();

        // create a Defult Wallet for admin
        $defaultWallet = new Wallet() ;
        $defaultWallet->setIdUser($admin);
        $defaultWallet->setName('Default');
        $manager->persist($defaultWallet);
        
        // Create a list of 10 cryptocurrencies
        $cryptos = [
            ['name'=>'Bitcoin'],
            ['name'=>'Ethereum'],
            ['name'=>'Ripple'],
            ['name'=>'Bitcoin-Cash'],
            ['name'=>'Cardano'],
            ['name'=>'Litecoin'],
            ['name'=>'NEM'],
            ['name'=>'Stellar'],
            ['name'=>'IOTA'],
            ['name'=>'Dash'],
        ];

    $listCrypto = [];
    foreach ($cryptos as $crypto) {
        $listCrypto[] = strtolower($crypto['name']);
    }

    $marketData = $this->coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);

    foreach ($marketData as $data) {
        $cryptocurrency = new Cryptocurrency();
        $cryptocurrency->setImage($data['image']);
        $cryptocurrency->setName(strtoupper($data['id']));
        $cryptocurrency->setAbreviation($data['symbol']);
        $manager->persist($cryptocurrency);
    }

    $manager->flush();

        // create DefaultWalletCrypto for admin
        $cryptocurrencies = $this->cryptocurrencyRepository->findAll();
        $initAmount=0;
        foreach ($cryptocurrencies as $cryptocurrency) {
            $defaultWalletCrypto=new WalletCrypto();
            $defaultWalletCrypto->setNameCrypto($cryptocurrency->getName());
            $defaultWalletCrypto->setWallet($defaultWallet);
            $defaultWalletCrypto->setSolde($initAmount);
            $defaultWalletCrypto->setCrypto($cryptocurrency);
            $defaultWalletCrypto->setActivation(true);
            $manager->persist($defaultWalletCrypto);
        }

        $manager->flush();
    }
}
