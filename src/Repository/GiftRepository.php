<?php

namespace App\Repository;

use App\Entity\Gift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gift>
 *
 * @method Gift|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gift|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gift[]    findAll()
 * @method Gift[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gift::class);
    }

    public function save(Gift $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gift $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCountExistingRecords()
    {
        $query = $this->createQueryBuilder('g')
            ->select('count(g.id) as totalRecords')

        ;

        return $query->getQuery()->getSingleScalarResult();
    }

    public function findGiftForEmployee($employeeId, $interests)
    {
        $query = $this->createQueryBuilder('g')
                    ->select("g")
                    ->leftJoin("g.giftCategories", "gc")
                    ->leftJoin("gc.category", "c")
                    ->leftJoin("g.employeeGift", "eg")

                    ->where('c.name IN (:name)')->setParameter('name', $interests)
                    ->andWhere('eg.id IS NULL')
                    ->setMaxResults(1)
                ;

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Gift[] Returns an array of Gift objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Gift
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
