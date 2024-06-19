<?php
namespace App\Services;

use App\Repository\UserRepository;
use App\Repository\WalletRepository;

class UserService
{
    private $userRepository;
    private $walletRepository;

    public function __construct(UserRepository $userRepository, WalletRepository $walletRepository)
    {
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
    }

    public function getUserByEmail(string $email)
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

    public function getUserWallets($user, $idWalletChoose)
    {
        $wallet=$this->walletRepository->findBy(['IdUser' => $user]);
        foreach($wallet as $w){
            if($w->getId() == $idWalletChoose){
                return $w;
            }
        }
    }
}