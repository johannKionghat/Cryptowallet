<?php

namespace App\Controller\Settings\Admin;

use App\Entity\Cryptocurrency;
use App\Entity\User;
use App\Entity\Wallet;
use App\Entity\WalletCrypto;
use App\Form\DeleteType;
use App\Form\ProfileType;
use App\Repository\CryptocurrencyRepository;
use App\Repository\UserRepository;
use App\Repository\WalletCryptoRepository;
use App\Repository\WalletRepository;
use App\Services\CoinGeckoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class CustomerController extends AbstractController
{
    //------------------------------------------- customers CRUD
    #[Route('/Admin/manage-customer', name: 'setting.customer')]
    public function index(UserRepository $userRepository): Response
    {
        $users=$userRepository->findAll();
        return $this->render('App/index.html.twig', [
            'users' => $users,
        ]);
    }
    //--------------------------------------------------------- Add Customer
    
    #[Route('/Admin/addCustomer', name: 'setting.addCustomer')]
    public function addCustomer(Request $request, EntityManagerInterface $em, User $user, UserPasswordHasherInterface $userPasswordHasher,CoinGeckoService $coinGeckoService, CryptocurrencyRepository $cryptocurrencyRepository){
        $form=$this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** 
             * @var UploadedFile $file 
             */
            $file=$form->get('thumbnailFile')->getData();
            if (!$file==null){
                $filename= $user->getId().'.'.$user->getEmail().$file->getClientOriginalExtension();
                $file->move($this->getParameter('kernel.project_dir').'/public/assets/images/users',$filename);
                $user->setThumbnail($filename);
            } 
            $defaultPassword='user';
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $defaultPassword
                )
            );
            $em->persist($user);
            $em->flush();
            // create a Defult Wallet for admin
            $defaultWallet = new Wallet() ;
            $defaultWallet->setIdUser($user);
            $defaultWallet->setName('Default');
            $em->persist($defaultWallet);
            
            // create DefaultWalletCrypto for admin
            $cryptocurrencies = $cryptocurrencyRepository->findAll();
            $initAmount=0;
            foreach ($cryptocurrencies as $cryptocurrency) {
                
                    $defaultWalletCrypto=new WalletCrypto();
                    $defaultWalletCrypto->setNameCrypto($cryptocurrency->getName());
                    $defaultWalletCrypto->setWallet($defaultWallet);
                    $defaultWalletCrypto->setSolde($initAmount);
                    $defaultWalletCrypto->setCrypto($cryptocurrency);
                    $defaultWalletCrypto->setActivation(true);
                    $em->persist($defaultWalletCrypto);
                
            }
            $em->flush();
            
            $this->addFlash('success','User added with success !');
            return $this->redirectToRoute('setting.customer');
            }
            return $this->render('App/index.html.twig',[
                'formAddCustomer'=>$form
            ]);
        }
    //---------------------------------------------------- Delete Customer
    #[Route('/Admin/deleteCustomer-{id}', name: 'setting.deleteCustomer', requirements:['id'=>Requirement::DIGITS])]
    public function deleteCustomer($id, UserRepository $userRepository, EntityManagerInterface $em, Request $request, WalletCryptoRepository $walletCryptoRepository, WalletRepository $walletRepository): Response
    {
        $formDelete = $this->createForm(DeleteType::class);
        $formDelete->handleRequest($request);
        $user = $userRepository->findOneBy(['id' => $id]);
    
        if (!$user) {
            $this->addFlash('error', 'User not found!');
            return $this->redirectToRoute('setting.customer');
        }
    
        if ($formDelete->isSubmitted() && $formDelete->isValid()) {
            $wallets = $walletRepository->findBy(['IdUser' => $user]);
            foreach ($wallets as $wallet) {
                $walletCryptos = $walletCryptoRepository->findBy(['wallet' => $wallet]);
                foreach ($walletCryptos as $walletCrypto) {
                    $em->remove($walletCrypto);
                }
                $em->remove($wallet);
            }
    
            $em->remove($user);
            $em->flush();
    
            $this->addFlash('success', 'User deleted with success!');
            return $this->redirectToRoute('setting.customer');
        }
    
        return $this->render('App/index.html.twig', [
            'formDelete' => $formDelete,
        ]);
    }
    

    //-------------------------------------------------- Edit Customer
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
}