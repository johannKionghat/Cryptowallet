<?php

namespace App\Controller\Transaction;

use App\Entity\WalletCrypto;
use App\Form\TradeCryptoType;
use App\Form\TransactionStep1;
use App\Repository\CryptocurrencyRepository;
use App\Repository\UserRepository;
use App\Repository\WalletCryptoRepository;
use App\Repository\WalletRepository;
use App\Services\CoinGeckoService;
use App\Services\CryptocurrencyService;
use App\Services\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SellCryptoController extends AbstractController
{

    #[Route('/transaction/sell', name: 'transaction.sell')]
    public function index(Request $request, CoinGeckoService $coinGeckoService): Response
    {
        $formSellStep1 = $this->createForm(TransactionStep1::class);
        $formSellStep1->handleRequest($request);

        if ($formSellStep1->isSubmitted() && $formSellStep1->isValid()) {
            $cryptos = $formSellStep1->get('cryptos')->getData();
            $walletChoose = $formSellStep1->get('wallets')->getData();
            $idWalletChoose = $walletChoose->getId();

           // get rating 
           $listCrypto[]=strtolower($cryptos->getName());
           $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);
           $rating=$marketData[0]['current_price'];
           return $this->redirectToRoute('transaction.sell.form', ['id' => $cryptos->getId(), 'idWalletChoose' => $idWalletChoose, 'rating'=>$rating]);
        }

        return $this->render('App/index.html.twig', [
            'formSellStep1' => $formSellStep1,
        ]);
    }
    #[Route('/transaction/sell/{id}/{idWalletChoose}/{rating}', name: 'transaction.sell.form')]
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
        CoinGeckoService $coinGeckoService,
        TransactionService $transactionService,
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
            $amountEuro = $form->get('amount')->getData();

            $listCrypto [] = strtolower($cryptocurrency->getName());
            $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);
            $amount=($amount / $marketData[0]['current_price']); 
            $balanceFrom = $user->getBalance();
            $transactionType='Sell';
            
            if ($balanceFrom < $amountEuro) {
                $this->addFlash('danger','Transaction Failed : Insufisance Balance € '.$balanceFrom - $amount);
                return $this->redirectToRoute('transaction.sell');
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
    
            $walletCrypto->setSolde($walletCrypto->getSolde() - $amount);
            $user->setBalance($balanceFrom + $amountEuro);
            $transactionService->logTransaction($user, $user, $amount, $walletCrypto, $amountEuro, $transactionType);
            $em->flush();
            
            $this->addFlash('success', 'Cryptocurrency Sold successfully!');
            return $this->redirectToRoute('transaction.sell');
        }
        return $this->render('App/index.html.twig', [
            'rating'=>$rating,
            'formSellCrypto' => $form,
            'cryptoToSell'=>$cryptocurrency
        ]);
    }
}
