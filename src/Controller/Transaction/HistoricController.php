<?php

namespace App\Controller\Transaction;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HistoricController extends AbstractController
{
    #[Route('/transaction/historic', name: 'transaction.historic')]
    public function index(
     TransactionRepository $transactionRepository,
     UserRepository $userRepository,
    ): Response
    {
        $user= $userRepository->findOneBy(array('email'=>$this->getUser()->getUserIdentifier()));

        $transactions = $transactionRepository->findAllSortByDate($user);
        
        return $this->render('App/index.html.twig', [
            'controller_name' => 'Bitchest',
            'transactions'=> $transactions
        ]);
    }
}
