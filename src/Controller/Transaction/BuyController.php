<?php

namespace App\Controller\Transaction;

use App\Entity\WalletCrypto;
use App\Form\BuyCryptoType;
use App\Form\TradeCryptoType;
use App\Form\TransactionStep1;
use App\Repository\CryptocurrencyRepository;
use App\Repository\UserRepository;
use App\Repository\WalletCryptoRepository;
use App\Repository\WalletRepository;
use App\Services\CoinGeckoService;
use App\Services\CryptocurrencyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BuyController extends AbstractController
{

    #[Route('/transaction/buy', name: 'transaction.buy')]
    public function index(Request $request, CoinGeckoService $coinGeckoService): Response
    {
        $formBuyStep1 = $this->createForm(TransactionStep1::class);
        $formBuyStep1->handleRequest($request);

        if ($formBuyStep1->isSubmitted() && $formBuyStep1->isValid()) {
            $cryptos = $formBuyStep1->get('cryptos')->getData();
            $walletChoose = $formBuyStep1->get('wallets')->getData();
            $idWalletChoose = $walletChoose->getId();

           // get rating 
           $listCrypto[]=strtolower($cryptos->getName());
           $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);
           $rating=$marketData[0]['current_price'];
           return $this->redirectToRoute('transaction.buy.form', ['id' => $cryptos->getId(), 'idWalletChoose' => $idWalletChoose, 'rating'=>$rating]);
        }

        return $this->render('App/index.html.twig', [
            'formBuyStep1' => $formBuyStep1,
        ]);
    }
    #[Route('/transaction/buy/{id}/{idWalletChoose}/{rating}', name: 'transaction.buy.form')]
    public function buyCrypto(
        $id,
        $rating,
        $idWalletChoose,
        Request $request,
        EntityManagerInterface $em, 
        UserRepository $userRepository, 
        CryptocurrencyRepository $cryptocurrencyRepository, 
        WalletRepository $walletRepository, 
        WalletCryptoRepository $walletCryptoRepository,
        CryptocurrencyService $cryptocurrencyService,
    ): Response
    {
        $cryptocurrency = $cryptocurrencyService->findCryptocurrency($id);
        $form = $this->createForm(TradeCryptoType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $userEmail = $this->getUser()->getUserIdentifier();
            $user = $userRepository->findOneBy(array('email'=>$userEmail));
            $cryptocurrency = $cryptocurrencyRepository->findOneBy(array('id'=>$id));
            $amount = $form->get('amount')->getData();
            $balanceFrom = $user->getBalance();
            
            if ($balanceFrom < $amount) {
                $this->addFlash('danger','Transaction Failed : Insufisance Balance € '.$balanceFrom - $amount);
                return $this->redirectToRoute('transaction.buy');
            }
    
            $wallet = $walletRepository->findOneBy(['id' => $idWalletChoose]);
            $walletCrypto = $walletCryptoRepository->findOneBy(['wallet' => $wallet, 'crypto' => $cryptocurrency]);
            if (!$walletCrypto) {
                $walletCrypto = new WalletCrypto();
                $walletCrypto->setNameCrypto($cryptocurrency->getName());
                $walletCrypto->setWallet($wallet);
                $walletCrypto->setCrypto($cryptocurrency);
                $walletCrypto->setSolde(0);
                $walletCrypto->setActivation(true);
                $em->persist($walletCrypto);
            }
    
            $walletCrypto->setSolde($walletCrypto->getSolde() + $amount);
            $user->setBalance($balanceFrom - $amount);
            $em->flush();
    
            $this->addFlash('success', 'Cryptocurrency bought successfully!');
            return $this->redirectToRoute('transaction.buy');
        }
        return $this->render('App/index.html.twig', [
            'rating'=>$rating,
            'formBuyCrypto' => $form->createView(),
            'cryptoToBuy'=>$cryptocurrency
        ]);
    }
}
