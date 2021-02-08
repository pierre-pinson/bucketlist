<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function findWishesByCategory():array
    {
        //2 methodes possibles

        //mode dql
        $dql="SELECT wish FROM App\\Entity\Wish w
              JOIN wish.category c
              WHERE wish.isPublished=1
              ORDER BY w.dateCreated DESC" ;
        $query =$this->getEntityManager()->createQuery($dql);
        $wishes = $query->getResult();
        return $wishes;

        //mode queryBuilder
        $queryBuilder=$this->createQueryBuilder('w');
        $queryBuilder->addOrderBy('w.dateCreated', 'DESC');
        $queryBuilder->andWhere('w.isPublished=1')->join('w.category','c');

        $wishes = $query->getResult();
        return $wishes;
    }



    // /**
    //  * @return Wish[] Returns an array of Wish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wish
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
