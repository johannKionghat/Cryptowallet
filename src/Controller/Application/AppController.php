<?php
namespace App\Controller\Application;

use App\Entity\Wallet;
use App\Form\ChooseWalletType;
use App\Repository\CryptocurrencyRepository;
use App\Repository\UserRepository;
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

        // Select cryptocurrencies of the chosen wallet
        $walletCryptos = $walletCryptoRepository->findBy(array('wallet'=>$userWalletChoose));
        $soldeCryptoWalletCard=0;
        foreach( $walletCryptos as $wc) {
            $soldeCryptoWalletCard += $wc->getSolde();
        }
        $cryptocurrencies = $cryptocurrencyService->getAllCryptocurrencies();
        $listCrypto = $cryptocurrencyService->getCryptocurrencyNames();
        $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);

        return $this->render('App/index.html.twig', [
            'soldeCryptoWalletCard'=>$soldeCryptoWalletCard,
            'cryptocurrencies' => $cryptocurrencies,
            'walletCrypto' => $walletCryptos,
            'userWalletChoose' => $userWalletChoose,
            'formChooseWallet' => $formChooseWallet,
            'marketData' => $marketData,
        ]);
    }
}
