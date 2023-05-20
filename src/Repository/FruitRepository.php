<?php

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fruit>
 *
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    public function save(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCountExistingRecords()
    {
        $query = $this->createQueryBuilder('f')
            ->select('count(f.id) as totalRecords')

        ;

        return $query->getQuery()->getSingleScalarResult();
    }

    public function findFruits(array $searchFields, int $page, int $limit, bool $isFavorite = false)
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC');

        if (!empty($searchFields)) {
            foreach ($searchFields as $fieldName => $searchFieldValue) {
                $trimmedSearchFieldValue = trim($searchFieldValue);
                
                if ($trimmedSearchFieldValue!='') {
                    $qb->andWhere('p.'.$fieldName.' LIKE :'.$fieldName)
                        ->setParameter($fieldName, '%'.$trimmedSearchFieldValue.'%');
                }
            }
        }

        if (true === $isFavorite) {
            $qb->andWhere('p.isFavorite = 1');
        }

        $firstResult = ($page - 1) * $limit;
        $qb->setFirstResult($firstResult)
            ->setMaxResults($limit);
        
        return $qb->getQuery();
    }

    public function countFavoriteFruits()
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->andWhere('f.isFavorite = true')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
