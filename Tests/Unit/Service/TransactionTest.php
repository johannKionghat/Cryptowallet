<?php

namespace Tests\Unit\Service;

use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\WalletCrypto;
use App\Services\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TransactionServiceTest extends TestCase
{
    private $entityManager;
    private $transactionService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->transactionService = new TransactionService($this->entityManager);
    }

    public function testLogTransaction()
    {
        $user = $this->createMock(User::class);
        $userTo = $this->createMock(User::class);
        $walletCrypto = $this->createMock(WalletCrypto::class);
        $user->method('getId')->willReturn(1);
        $userTo->method('getId')->willReturn(2);

        $amount = 10.0;
        $amountEuro = 100.0;
        $transactionType = 'transfer';

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($transaction) use ($user, $userTo, $amount, $walletCrypto, $amountEuro, $transactionType) {
                return $transaction instanceof Transaction &&
                    $transaction->getUser() === $user &&
                    $transaction->getUserTo() === $userTo &&
                    $transaction->getAmountCrypto() === $amount &&
                    $transaction->getWalletCrypto() === $walletCrypto &&
                    $transaction->getAmountEuro() === $amountEuro &&
                    $transaction->getType() === $transactionType;
            }));

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->transactionService->logTransaction($user, $userTo, $amount, $walletCrypto, $amountEuro, $transactionType);
    }
}
