<?php

namespace App\Services;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;

class TransactionService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function logTransaction($user, $userTo, $amount, $walletCrypto, $amountEuro, $transactionType): void
    {
        $transaction = new Transaction();
        
        $transaction->setUser($user);
        $transaction->setUserTo($userTo);
        $transaction->setAmountCrypto($amount);
        $transaction->setWalletCrypto($walletCrypto);
        $transaction->setAmountEuro($amountEuro);
        $transaction->setDateAt(new \DateTimeImmutable());
        $transaction->setType($transactionType);

        $this->em->persist($transaction);
        $this->em->flush();
    }
}
