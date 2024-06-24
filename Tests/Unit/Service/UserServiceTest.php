<?php 
namespace Tests\Unit\Service;

use App\Entity\Wallet;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use App\Services\UserService;
use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserServiceTest extends TestCase
{
    private $userRepository;
    private $walletRepository;
    private $userService;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->walletRepository = $this->createMock(WalletRepository::class);
        $this->userService = new UserService($this->userRepository, $this->walletRepository);
    }

    public function testGetUserByEmail()
    {
        $user = new User();
        $user->setEmail('admin@admin.test');
        $this->userRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'admin@admin.test'])
            ->willReturn($user);
        $result = $this->userService->getUserByEmail('admin@admin.test');
        $this->assertSame($user, $result);
    }
    public function testGetUserWallets(){

        $user = new User();

        $wallet1 = $this->createMock(Wallet::class);
        $wallet1->method('getId')->willReturn(1);

        $wallet2 = $this->createMock(Wallet::class);
        $wallet2->method('getId')->willReturn(2);

        $this->walletRepository->expects($this->once())
            ->method('findBy')
            ->with(['IdUser' => $user])
            ->willReturn([$wallet1, $wallet2]);

        $idWalletChoose = 2;

        $result = $this->userService->getUserWallets($user, $idWalletChoose);

        $this->assertSame($wallet2, $result);
    }
}
