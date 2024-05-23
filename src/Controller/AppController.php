<?php

namespace App\Controller;

use App\Entity\Cryptocurrency;
use App\Entity\User;
use App\Repository\CryptocurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use App\Services\CoinGeckoService;

class AppController extends AbstractController
{
    private $coinGeckoService;

    public function __construct(CoinGeckoService $coinGeckoService)
    {
        $this->coinGeckoService = $coinGeckoService;
    }
    #[Route('/accueil', name: 'accueil')]
    public function index(CryptocurrencyRepository $cryptocurrencyRepository): Response
    {   
        $prices = $this->coinGeckoService->getPrices(['bitcoin', 'ethereum', 'ripple', 'bitcoin-cash','cardano', 'litecoin', 'nem', 'stellar', 'iota', 'dash']);
        $cryptocurrencies=$cryptocurrencyRepository->findAll();
        return $this->render('App/index.html.twig',[
            'cryptocurrencies'=>$cryptocurrencies,
            'prices'=>$prices
        ]);
    }
}
