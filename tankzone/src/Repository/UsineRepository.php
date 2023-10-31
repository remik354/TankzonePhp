<?php

namespace App\Repository;

use App\Entity\Usine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Usine>
 *
 * @method Usine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usine[]    findAll()
 * @method Usine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usine::class);
    }

//    /**
//     * @return Usine[] Returns an array of Usine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Usine
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
