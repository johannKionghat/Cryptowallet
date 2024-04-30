<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class AppController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(): Response
    {   
        return $this->render('user/index.html.twig');
    }
}
