<?php
namespace App\Controller\Transaction;

use App\Form\SendCryptoType;
use App\Form\SendStape2Type;
use App\Form\SendType;
use App\Form\TransactionStep1;
use App\Services\CoinGeckoService;
use App\Services\CryptocurrencyService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SendCryptoController extends AbstractController
{
    private $userService;
    private $cryptocurrencyService;

    public function __construct(UserService $userService, CryptocurrencyService $cryptocurrencyService,)
    {
        $this->userService = $userService;
        $this->cryptocurrencyService = $cryptocurrencyService;
    }

    #[Route('/transaction/send', name: 'transaction.send')]
    public function index(Request $request, CoinGeckoService $coinGeckoService): Response
    {
        $formSendStep1 = $this->createForm(TransactionStep1::class);
        $formSendStep1->handleRequest($request);

        if ($formSendStep1->isSubmitted() && $formSendStep1->isValid()) {
            $cryptos = $formSendStep1->get('cryptos')->getData();
            $walletChoose = $formSendStep1->get('wallets')->getData();
            $idWalletChoose = $walletChoose->getId();

            // get rating 
            $listCrypto[]=strtolower($cryptos->getName());
            $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);
            $rating=$marketData[0]['current_price'];
            return $this->redirectToRoute('transaction.send.form', ['id' => $cryptos->getId(), 'idWalletChoose' => $idWalletChoose, 'rating'=>$rating]);
        }

        return $this->render('App/index.html.twig', [
            'formSendStep1' => $formSendStep1,
        ]);
    }

    #[Route('/transaction/send/{id}/{idWalletChoose}/{rating}', name: 'transaction.send.form', requirements: ['id' => '\d+'])]
    public function send(
        Request $request,
        $id,
        $idWalletChoose,
        $rating
        
    ): Response
    {
        $cryptocurrency = $this->cryptocurrencyService->findCryptocurrency($id);
        
        $formSendStep2 = $this->createForm(SendCryptoType::class,$cryptocurrency);
        $formSendStep2->handleRequest($request);

        if ($formSendStep2->isSubmitted() && $formSendStep2->isValid()) {
            $adressTo = $formSendStep2->get('adressTo')->getData();
            $adressTo = explode('x0', $adressTo);
            $amount = $formSendStep2->get('amount')->getData();
            $idWalletTo = $adressTo[1];
            $nameCryptoTo = $adressTo[3];

            $emailUser = $this->getUser()->getUserIdentifier();
            $user = $this->userService->getUserByEmail($emailUser);
            $walletUser = $this->userService->getUserWallets($user,$idWalletChoose);
            $walletCryptoUser = $this->cryptocurrencyService->getWalletCryptocurrencies($walletUser);

            $emailUserTo=base64_decode($adressTo[4]);
            $userTo = $this->userService->getUserByEmail($emailUserTo);
            $walletUserTo = $this->userService->getUserWallets($userTo, $idWalletTo);
            $walletCryptoUserTo = $this->cryptocurrencyService->getWalletCryptocurrencies($walletUserTo);
            if ($nameCryptoTo != $cryptocurrency->getName()) {
                $this->addFlash('danger', 'The address to send is not in the same network, please check your address.');
                return $this->redirectToRoute('transaction.send');
            }

            if (!$this->cryptocurrencyService->updateWalletBalances($walletCryptoUser, $walletCryptoUserTo, $amount, $nameCryptoTo, $idWalletChoose, $idWalletTo)) {
                $this->addFlash('danger', 'Transaction failed: you don\'t have enough ' . $nameCryptoTo . ' to continue this operation');
                return $this->redirectToRoute('transaction.send');
            }

            $this->addFlash('success', "Crypto sent successfully to " . $userTo->getEmail());
        }

        return $this->render('App/index.html.twig', [
            'rating'=>$rating,
            'formSendStep2' => $formSendStep2,
            'cryptotosend' => $cryptocurrency
        ]);
    }
}
