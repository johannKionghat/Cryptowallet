<?php

namespace App\Controller;

use App\Entity\Cryptocurrency;
use App\Entity\User;
use App\Form\CryptoType;
use App\Form\DeleteCustomerType;
use App\Form\DeleteType;
use App\Form\ProfileType;
use App\Repository\CryptocurrencyRepository;
use App\Repository\UserRepository;
use App\Services\CoinGeckoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class AdminController extends AbstractController
{
    // customers management
    #[Route('/Admin/manage-customer', name: 'setting.customer')]
    public function index(UserRepository $userRepository): Response
    {
        $users=$userRepository->findAll();
        return $this->render('App/index.html.twig', [
            'users' => $users,
        ]);
    }
    #[Route('/Admin/addCustomer', name: 'setting.addCustomer')]
    public function addCustomer(Request $request, EntityManagerInterface $em, User $user, UserPasswordHasherInterface $userPasswordHasher){
        $form=$this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** @var UploadedFile $file */
            $file=$form->get('thumbnailFile')->getData();
            if (!$file==null){
                $filename= $user->getId().'.'.$user->getEmail().$file->getClientOriginalExtension();
                $file->move($this->getParameter('kernel.project_dir').'/public/assets/images/users',$filename);
                $user->setThumbnail($filename);
            }
            $randomPassword = bin2hex(random_bytes(12)); 
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $randomPassword
                )
            );
            
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','User added with success !');
            return $this->redirectToRoute('setting.customer');
        }
        return $this->render('App/index.html.twig',[
            'formAddCustomer'=>$form
        ]);
    }
    #[Route('/Admin/deleteCustomer-{id}', name: 'setting.deleteCustomer', requirements:['id'=>Requirement::DIGITS])]
    public function deleteCustomer ($id, Cryptocurrency $cryptocurrency,EntityManagerInterface $em, Request $request){
        $formDelete=$this->createForm(DeleteType::class);
        $formDelete->handleRequest($request);
        if ($formDelete->isSubmitted() && $formDelete->isValid()){
            $em->remove($cryptocurrency);
            $em->flush();
            return $this->redirectToRoute('setting.customer');
        }
        return $this->render('App/index.html.twig',[
            'formDelete'=>$formDelete
        ]);
    }
    #[Route('/Admin/editCusomer-{id}', name: 'setting.editCustomer', requirements:['id'=>Requirement::DIGITS])]
    public function editCustomer (User $user, Request $request, $id, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /** @var UploadedFile $file */
            $file=$form->get('thumbnailFile')->getData();
            if (!$file==null){
                $filename= $user->getId().'.'.$user->getEmail().$file->getClientOriginalExtension();
                $file->move($this->getParameter('kernel.project_dir').'/public/assets/images/users',$filename);
                $user->setThumbnail($filename);
            }
            $role = $form->get('roles')->getData();
            if($role==='admin'){
                $user->setRoles([1]);
            }
            if($role==='user'){
                $user->setRoles([]);
            }
            $state=$form->get('state')->getData();
            $user->setIsVerified($state);
            $em->flush();
            $this->addFlash('success','Customer edit with success');
            return $this->redirectToRoute('setting.customer',['id'=>$id]);
        }
        return $this->render('App/index.html.twig', [
            'formEditCustomer' => $form,
            'customer'=>$user,
        ]);
    }
    // cryptocurrency management
    #[Route('/Admin/manage-cryptocurrency', name: 'setting.cryptocurrency')]
    public function index2(CryptocurrencyRepository $cryptocurrencyRepository): Response
    {
        $cryptocurrencies=$cryptocurrencyRepository->findAll();
        return $this->render('App/index.html.twig', [
            'cryptocurrencies' => $cryptocurrencies,
        ]);
    }
    #[Route('/Admin/addCrypto', name: 'setting.addCrypto')]
    public function addCrypto(Request $request, EntityManagerInterface $em, Cryptocurrency $cryptocurrency, CryptocurrencyRepository $cryptocurrencyRepository, CoinGeckoService $coinGeckoService){

        $form=$this->createForm(CryptoType::class, $cryptocurrency);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        // liste de tous les cryptomonaies 
        $cryptocurrencies=$cryptocurrencyRepository->findAll();
        // verification de la cryptomonaie à ajouter
        for ($i = 0; $i < count($cryptocurrencies); $i++) {
            if ($form->getData()->getName() == $cryptocurrencies[$i]->getName()){
                $this->addFlash('danger','Crypto not added because it is already in database !');
                return $this->redirectToRoute('setting.cryptocurrency');
            }
            $listCrypto[]=strtolower($form->getData()->getName());
        }
        $marketData = $coinGeckoService->getMarketData('eur', $listCrypto, 10, 1);
        // on verifie si la cryptomonaie exist dans la blockchain
        if ($marketData == []){
            $this->addFlash('danger','Crypto not added because it is not exist in blockchain');
            return $this->redirectToRoute('setting.cryptocurrency'); 
        }
        if(!$marketData == []){
            $cryptocurrency->setImage($marketData[0]['image']);
            $cryptocurrency->setAbreviation($marketData[0]['symbol']);
            $em->persist($cryptocurrency);
            $em->flush();
            $this->addFlash('success','New Crypto added with success !');
            return $this->redirectToRoute('setting.cryptocurrency');
        }
        }
        return $this->render('App/index.html.twig',[
            'formAddCrypto'=>$form
        ]);
    }
    #[Route('/Admin/deleteCrypto-{id}', name: 'setting.deleteCrypto', requirements:['id'=>Requirement::DIGITS])]
    public function deleteCrypto ($id, Cryptocurrency $cryptocurrency, EntityManagerInterface $em, Request $request){
        $formDelete=$this->createForm(DeleteType::class);
        $formDelete->handleRequest($request);
        if ($formDelete->isSubmitted() && $formDelete->isValid()){
            $em->remove($cryptocurrency);
            $em->flush();
            return $this->redirectToRoute('setting.cryptocurrency');
        }
        return $this->render('App/index.html.twig',[
            'formDeleteCrypto'=>$formDelete
        ]);
    }
}
