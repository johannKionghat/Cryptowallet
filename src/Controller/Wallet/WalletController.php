<?php

namespace App\Controller\Wallet;

use App\Entity\Wallet;
use App\Entity\WalletCrypto;
use App\Form\DeleteType;
use App\Form\WalletType;
use App\Repository\CryptocurrencyRepository;
use App\Repository\UserRepository;
use App\Repository\WalletCryptoRepository;
use App\Repository\WalletRepository;
use App\Services\CoinGeckoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class WalletController extends AbstractController
{
    #[Route('/wallet', name: 'wallet')]
    public function index(WalletRepository $walletRepository, UserRepository $userRepository): Response
    {
        $emailUser = $this->getUser()->getUserIdentifier();
        $user= $userRepository->findOneBy(array('email'=> $emailUser));
        $Wallets=$walletRepository->findAll();
        foreach ($Wallets as $w){
            if(($w->getIdUser()->getId())== $user->getId()){
                $userWallet[]=$w;
            }
        }
        return $this->render('App/index.html.twig', [
            'wallets'=>$userWallet
        ]);
    }

    // Ajout d'un wallet par l'utilisateur
    #[Route('/wallet/add', name:'wallet.add')]
    public function addWallet(Request $request,CoinGeckoService $coinGeckoService, CryptocurrencyRepository $cryptocurrencyRepository, UserRepository $userRepository, Wallet $wallet,EntityManagerInterface $em): Response
    {
        $form= $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);
        $emailUser =$this->getUser()->getUserIdentifier();
        $user=$userRepository->findOneBy(array('email'=> $emailUser));
        $initAmount=0;

        if( $form->isSubmitted() && $form->isValid() ) {
            $wallet->setIdUser($user);
            $em->persist($wallet);
            $em->flush();

            // create DefaultWalletCrypto for user
            $cryptocurrencies = $cryptocurrencyRepository->findAll();
            $initAmount=0;
            foreach ($cryptocurrencies as $cryptocurrency) {
                $defaultWalletCrypto=new WalletCrypto();
                $defaultWalletCrypto->setNameCrypto($cryptocurrency->getName());
                $defaultWalletCrypto->setWallet($wallet);
                $defaultWalletCrypto->setSolde($initAmount);
                $defaultWalletCrypto->setCrypto($cryptocurrency);
                $defaultWalletCrypto->setActivation(true);
                $em->persist($defaultWalletCrypto);
            }
            $em->flush();   
            $this->addFlash('success','Wallet create with success.');
            return $this->redirectToRoute('wallet');
            }
        elseif($form->isSubmitted() && !$form->isValid() ) {
            $this->addFlash('Error','The name is already used');
            return $this->redirectToRoute('wallet.add');
        }
        return $this->render('App/index.html.twig', [
            'formWallet' => $form,
            ]);
        }

        #[Route('wallet/edit/{id}', name:'wallet.edit')]
        public function editWallet(Request $request, Wallet $wallet, WalletRepository $walletRepository, EntityManagerInterface $em, $id): Response
        {
            $form= $this->createForm(WalletType::class, $wallet);
            $form->handleRequest($request);
            $wallet = $walletRepository->find($id);   
            if( $form->isSubmitted() && $form->isValid() ) {
                $wallet->setName($form->get('Name')->getData());
                $em->persist($wallet);
                $em->flush();
                $this->addFlash('success','Wallet edit with succes');
                return $this->redirectToRoute('wallet');
            }
            elseif($form->isSubmitted() && !$form->isValid() ){
                $this->addFlash('Error','The name is already used');
                return $this->redirectToRoute('wallet.edit',['id'=> $id]);
            }
            return $this->render('App/index.html.twig',[
                'formEditWallet'=>$form,
            ]);
        }
        #[Route('wallet/delete/{id}', name: 'wallet.delete', requirements:['id'=>Requirement::DIGITS])]
        public function deleteCrypto ($id, Wallet $wallet,WalletCryptoRepository $walletCryptoRepository, EntityManagerInterface $em, Request $request){
            $formDelete=$this->createForm(DeleteType::class);
            $formDelete->handleRequest($request);
            $walletCryptos=$walletCryptoRepository->findBy(array('wallet'=>$wallet));
            if ($formDelete->isSubmitted() && $formDelete->isValid()){
                foreach ($walletCryptos as $walletCrypto){
                    $em->remove($walletCrypto);
                }
                $em->remove($wallet);
                $em->flush();
                $this->addFlash('success','wallet deleted with success !');
                return $this->redirectToRoute('wallet');
            }
            return $this->render('App/index.html.twig',[
                'formDeleteWallet'=>$formDelete
            ]);
        }
    }