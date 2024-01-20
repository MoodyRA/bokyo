<?php

namespace App\Repository;

use App\Entity\WalletAsset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WalletAsset>
 *
 * @method WalletAsset|null find($id, $lockMode = null, $lockVersion = null)
 * @method WalletAsset|null findOneBy(array $criteria, array $orderBy = null)
 * @method WalletAsset[]    findAll()
 * @method WalletAsset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletAssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WalletAsset::class);
    }

//    /**
//     * @return WalletAsset[] Returns an array of WalletAsset objects
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

//    public function findOneBySomeField($value): ?WalletAsset
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
