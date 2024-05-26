<?php

namespace App\Controller;

use App\Entity\Cryptocurrency;
use App\Repository\CryptocurrencyRepository;
use App\Services\CoinGeckoDataGraph;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\CoinGeckoService;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Name;

class AppController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(CryptocurrencyRepository $cryptocurrencyRepository, CoinGeckoService $coinGeckoService, CoinGeckoDataGraph $coinGeckoDataGraph, EntityManagerInterface $em): Response
    {   
        // liste de tous les cryptomonaies 
        $cryptocurrencies=$cryptocurrencyRepository->findAll();
        for ($i = 0; $i < count($cryptocurrencies); $i++) {
            $listCrypto[]=strtolower($cryptocurrencies[$i]->getName());
        }
        $dataGraph = $coinGeckoDataGraph->getMarketChart('bitcoin', 'eur', 30);
        $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);
        return $this->render('App/index.html.twig',[
            'marketData'=>$marketData,
            'marketChart'=>$dataGraph,
        ]);
    }
}
