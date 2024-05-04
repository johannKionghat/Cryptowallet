<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\DeleteProfileType;
use App\Form\ProfileType;
use App\Form\SecurityType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ProfileController extends AbstractController
{
    #[Route('/setting/profile-{id}', name: 'setting.profile', requirements:['id'=>Requirement::DIGITS])]
    public function index(User $user, Request $request, $id, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success','Profile edit with success');
            return $this->redirectToRoute('setting.profile',['id'=>$id]);
        }
        return $this->render('user/index.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/setting/security-{id}', name: 'setting.security', requirements:['id'=>Requirement::DIGITS])]
    public function securityProfile(User $user, Request $request, $id, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher):response{
        $form = $this->createForm(SecurityType::class, $user);
        $form->handleRequest($request);   
        if ($form -> isSubmitted() && $form -> isValid()){
            $data=$request->request->all();
            $newPassword=$data['security']['password'];
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $newPassword
                )
            );
            $em->flush();
            $this->addFlash('success','Password changed with success !');
            return $this->redirectToRoute('setting.security',['id'=>$id]);
        }
        return $this->render('user/index.html.twig', [
            'form' => $form,
        ]);
    }
}
