<?php

namespace App\Controller;

use App\Entity\Cryptocurrency;
use App\Entity\User;
use App\Repository\CryptocurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class AppController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(CryptocurrencyRepository $cryptocurrencyRepository): Response
    {   
        $cryptocurrencies=$cryptocurrencyRepository->findAll();
        return $this->render('user/index.html.twig',[
            'cryptocurrencies'=>$cryptocurrencies
        ]);
    }
}
