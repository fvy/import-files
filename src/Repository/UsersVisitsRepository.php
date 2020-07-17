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
    public function findByExampleField()
    {
        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
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

    public function findAllVisits(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select * from users_visits
        ';
        $stmt = $conn->prepare($sql);
        //$stmt->execute(['price' => $price]);
        $stmt->execute();
        print_r("<pre style='background-color: black; color: limegreen;'>");
        print_r($stmt->fetchAll());
        print_r("</pre>");
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
