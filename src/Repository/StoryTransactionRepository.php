<?php

namespace App\Repository;

use App\Entity\StoryTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StoryTransaction>
 *
 * @method StoryTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoryTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoryTransaction[]    findAll()
 * @method StoryTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoryTransaction::class);
    }

//    /**
//     * @return StoryTransaction[] Returns an array of StoryTransaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StoryTransaction
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
