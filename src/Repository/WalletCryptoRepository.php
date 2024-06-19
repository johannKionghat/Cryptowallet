<?php

namespace App\Repository;

use App\Entity\WalletCrypto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WalletCrypto>
 *
 * @method WalletCrypto|null find($id, $lockMode = null, $lockVersion = null)
 * @method WalletCrypto|null findOneBy(array $criteria, array $orderBy = null)
 * @method WalletCrypto[]    findAll()
 * @method WalletCrypto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletCryptoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WalletCrypto::class);
    }

//    /**
//     * @return WalletCrypto[] Returns an array of WalletCrypto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WalletCrypto
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
