<?php

namespace App\Repository;

use App\Entity\UsersVisits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsersVisits|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersVisits|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersVisits[]    findAll()
 * @method UsersVisits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersVisitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersVisits::class);
    }

    /**
    * @return UsersVisits[] Returns an array of UsersVisits objects
    */
//    public function findByExampleField()
//    {
//        return $this->createQueryBuilder('u')
////            ->andWhere('u.exampleField = :val')
////            ->setParameter('val', $value)
////            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findAllVisits(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $stmt = $conn->prepare(
            'select * from users_visits 
            inner join users_environments on (visit_ip = user_ip)
            where 1 = 1
        '
        );
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    /*
    public function findOneBySomeField($value): ?UsersVisits
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
