<?php

namespace App\Controller\Transaction;

use App\Form\ChooseWalletType;
use App\Repository\CryptocurrencyRepository;
use App\Repository\WalletRepository;
use App\Services\QrcodeService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ReceiveController extends AbstractController
{
    #[Route('/transaction/receive', name: 'transaction.receive')]
    public function index(CryptocurrencyRepository $cryptocurrencyRepository): Response
    {
        $cryptocurrencies= $cryptocurrencyRepository->findAll();
        return $this->render('App/index.html.twig', [
            'cryptocurrenciesReceive' => $cryptocurrencies,
        ]);
    }
    #[Route('/transaction/receive/{id}', name: 'transaction.receive.action', requirements:['id'=>Requirement::DIGITS])]
    public function send(
        $id,
        Request $request,
        QrcodeService $qrcodeService,
        CryptocurrencyRepository $cryptocurrencyRepository,
        WalletRepository $walletRepository,
        UserService $userService,
        ): Response{   
            
        $cryptotoreceive= $cryptocurrencyRepository->find($id);
        $emailUser = $this->getUser()->getUserIdentifier();
        $user= $userService->getUserByEmail($emailUser);
        $walletUser=$walletRepository->findBy(array('IdUser'=>$user));

        $userWalletChoose = $walletUser[0];
        $formChooseWallet = $this->createForm(ChooseWalletType::class);
        $formChooseWallet->handleRequest($request);

        if ($formChooseWallet->isSubmitted() && $formChooseWallet->isValid()) {
            $userWalletChoose = $formChooseWallet->get('name')->getData();
            
        }

        $idUser=$user->getId();
        $idWallet=$userWalletChoose->getId();
        $idCrypto=$cryptotoreceive->getId();
        $nameCrypto=$cryptotoreceive->getName();

        $adressCrypto = $idUser."x0".$idWallet."x0".$idCrypto."x0".$nameCrypto."x0".base64_encode($emailUser);
        $qrcode = $qrcodeService->generateQrCode($adressCrypto);
        return $this->render('App/index.html.twig', [
            'adressCrypto'=>$adressCrypto,
            'cryptotoreceive'=>$cryptotoreceive,
            'qrcode'=> $qrcode,
            'formSelectWallet'=>$formChooseWallet,

        ]);
    }
}
