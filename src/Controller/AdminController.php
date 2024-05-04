<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\DeleteCustomerType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class AdminController extends AbstractController
{
    #[Route('/Admin/manage-customer', name: 'setting.customer')]
    public function index(UserRepository $userRepository): Response
    {
        $users=$userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    #[Route('/Admin/deleteCustomer-{id}', name: 'setting.deleteCustomer', requirements:['id'=>Requirement::DIGITS])]
    public function deleteCustomer ($id, User $user,EntityManagerInterface $em, Request $request){
        $formDelete=$this->createForm(DeleteCustomerType::class);
        $formDelete->handleRequest($request);
        if ($formDelete->isSubmitted() && $formDelete->isValid()){
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('user/index.html.twig');
        }
        return $this->render('user/index.html.twig',[
            'formDelete'=>$formDelete
        ]);
    }
}
