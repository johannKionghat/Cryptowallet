<?php

namespace App\Controller\Transaction;

use App\Form\SellCryptoType;
use App\Repository\CryptocurrencyRepository;
use App\Repository\UserRepository;
use App\Repository\WalletCryptoRepository;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SellCryptoController extends AbstractController
{
    #[Route('/transaction/sell', name: 'transaction.sell')]
    public function sellCrypto(
        Request $request, 
        EntityManagerInterface $em, 
        UserRepository $userRepository, 
        CryptocurrencyRepository $cryptocurrencyRepository, 
        WalletRepository $walletRepository, 
        WalletCryptoRepository $walletCryptoRepository): Response
{
    $form = $this->createForm(SellCryptoType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $user = $userRepository->find($data['user']);
        $cryptocurrency = $cryptocurrencyRepository->find($data['cryptocurrency']);
        $amount = $data['amount'];

        $wallet = $walletRepository->findOneBy(['IdUser' => $user]);
        $walletCrypto = $walletCryptoRepository->findOneBy(['wallet' => $wallet, 'crypto' => $cryptocurrency]);

        if (!$walletCrypto || $walletCrypto->getSolde() < $amount) {
            $this->addFlash('error', 'Insufficient balance or cryptocurrency not found in wallet!');
            return $this->redirectToRoute('setting.customer');
        }

        $walletCrypto->setSolde($walletCrypto->getSolde() - $amount);
        $em->flush();

        $this->addFlash('success', 'Cryptocurrency sold successfully!');
        return $this->redirectToRoute('transaction.sell');
    }

    return $this->render('App/index.html.twig', [
        'formSellCrypto' => $form->createView(),
    ]);
}
}
