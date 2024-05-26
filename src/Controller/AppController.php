<?php

namespace App\Controller;


use App\Repository\CryptocurrencyRepository;
use App\Services\CoinGeckoDataGraph;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\CoinGeckoService;

class AppController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(CryptocurrencyRepository $cryptocurrencyRepository, CoinGeckoService $coinGeckoService, CoinGeckoDataGraph $coinGeckoDataGraph): Response
    {   
        $dataGraph = $coinGeckoDataGraph->getMarketChart('bitcoin', 'eur', 30);
        $prices = $coinGeckoService->getPrices(['bitcoin', 'ethereum', 'ripple', 'bitcoin-cash','cardano', 'litecoin', 'nem', 'stellar', 'iota', 'dash']);
        $cryptocurrencies=$cryptocurrencyRepository->findAll();
        return $this->render('App/index.html.twig',[
            'cryptocurrencies'=>$cryptocurrencies,
            'prices'=>$prices,
            'marketChart'=>$dataGraph,
        ]);
    }
}
