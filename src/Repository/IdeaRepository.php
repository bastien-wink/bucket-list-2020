<?php

namespace App\Repository;

use App\Entity\Idea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Idea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Idea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Idea[]    findAll()
 * @method Idea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Idea::class);
    }

    public function findRecent()
    {
        $qb = $this->createQueryBuilder('i')
                ->where('i.dateCreated > :startDate')
                ->setParameter('startDate', (new \DateTime())->modify('-1 month'))
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function search($search, $order)
    {
        $qb = $this->createQueryBuilder('i')
                ->where('i.isPublished = 1')
                ->andWhere('i.title LIKE :search')
                ->setParameter('search', "%".$search."%")
                ->orderBy('i.'.$order, 'asc')
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    // /**
    //  * @return Idea[] Returns an array of Idea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Idea
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
