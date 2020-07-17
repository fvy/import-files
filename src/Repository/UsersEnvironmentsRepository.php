<?php

namespace App\Repository;

use App\Entity\UsersEnvironments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsersEnvironments|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersEnvironments|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersEnvironments[]    findAll()
 * @method UsersEnvironments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersEnvironmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersEnvironments::class);
    }

    // /**
    //  * @return UsersEnvironments[] Returns an array of UsersEnvironments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsersEnvironments
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
