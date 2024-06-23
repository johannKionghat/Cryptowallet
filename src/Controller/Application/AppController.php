<?php
namespace App\Controller\Application;

use App\Form\ChooseWalletType;
use App\Repository\CryptocurrencyRepository;
use App\Repository\WalletCryptoRepository;
use App\Repository\WalletRepository;
use App\Services\UserService;
use App\Services\CryptocurrencyService;
use App\Services\CoinGeckoService;
use App\Services\CoinGeckoDataGraph;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(
        Request $request,
        UserService $userService,
        CryptocurrencyService $cryptocurrencyService,
        CoinGeckoService $coinGeckoService,
        WalletCryptoRepository $walletCryptoRepository,
        WalletRepository $walletRepository
    ): Response {
        // Get the current user and their wallets
        $emailUser = $this->getUser()->getUserIdentifier();
        $user = $userService->getUserByEmail($emailUser);
        $userWallets = $walletRepository->findBy(array('IdUser'=>$user));
        // Set the default wallet to the first one
        $userWalletChoose = $userWallets[0];
        $formChooseWallet = $this->createForm(ChooseWalletType::class);
        $formChooseWallet->handleRequest($request);

        if ($formChooseWallet->isSubmitted() && $formChooseWallet->isValid()) {
            $userWalletChoose = $formChooseWallet->getData();
        }

        $cryptocurrencies = $cryptocurrencyService->getAllCryptocurrencies();
        $listCrypto = $cryptocurrencyService->getCryptocurrencyNames();
        $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);
        // Select cryptocurrencies of the chosen wallet
        $walletCryptos = $walletCryptoRepository->findBy(array('wallet'=>$userWalletChoose));

        $soldeCryptoWalletCard=0;
        foreach( $walletCryptos as $wc) {
            $arrayCrypto = strTolower($wc->getNameCrypto());
            $cryptoEuro = $coinGeckoService->getMarketData('eur', [$arrayCrypto], 10, 1);
            $soldeEuro = $wc->getSolde() * $cryptoEuro[0]['current_price'];
            $soldeCryptoWalletCard += $soldeEuro;
        }
        
        return $this->render('App/index.html.twig', [
            'soldeCryptoWalletCard'=>$soldeCryptoWalletCard,
            'cryptocurrencies' => $cryptocurrencies,
            'walletCrypto' => $walletCryptos,
            'userWalletChoose' => $userWalletChoose,
            'formChooseWallet' => $formChooseWallet,
            'marketData' => $marketData,
        ]);
    }
    #[Route(path:'cryptoDetails/{id}/{idWalletChoose}', name:'cryptoDetails')]
    public function showDetails(
        $id,
        $idWalletChoose,
        CoinGeckoDataGraph $coinGeckoDataGraph,
        WalletCryptoRepository $walletCryptoRepository,
        WalletRepository $walletRepository,
        CryptocurrencyRepository $cryptocurrencyRepository,
        CoinGeckoService $coinGeckoService,
    ): Response
    {
        $w=$walletRepository->findOneBy(array('id'=>$idWalletChoose));
        $wc=$walletCryptoRepository->findOneBy(array('wallet'=>$w,'nameCrypto'=>$id));
        $c=$cryptocurrencyRepository->findOneBy(array('Name'=>strtoupper($id)));
        $marketChart = $coinGeckoDataGraph->getMarketChart($id, 'eur', 360);
        $listCrypto[] = strtolower($c->getName()); 
        $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);
        return $this->render('App/index.html.twig', [
            'm'=>$marketData,
            'c'=>$c,
            'wc'=>$wc,
            'marketChart'=> $marketChart,
        ]);
    }
}
