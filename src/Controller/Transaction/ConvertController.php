<?php

namespace App\Controller\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ConvertController extends AbstractController
{
    #[Route('/transaction/convert', name: 'transaction.convert')]
    public function index(): Response
    {
        return $this->render('App/index.html.twig', [
            'controller_name' => 'Bitchest',
        ]);
    }
}
