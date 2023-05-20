<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Fruit;

class FruitService
{
    private $em;
    public function __construct(private ManagerRegistry $mr, private PaginatorInterface $paginator)
    {
        $this->em = $mr->getManagerForClass(get_class(new Fruit()));
    }

    public function getFruits(array $searchFields, int $page, int $limit = 10)
    {
        $fruits = $this->em->getRepository(Fruit::class)->findFruits($searchFields, $page, $limit);
        
        $pagination = $this->paginator->paginate($fruits, $page, $limit);
        
        return $pagination;
    }

    public function markFavorite(int $fruitId, bool $isFavorite = null)
    {
        $responose = ['status' => false, 'msg' => 'fruit not found'];
        
        $fruit = $this->em->getRepository(Fruit::class)->find($fruitId);
        if ($fruit) {
            $responose = ['status' => true, 'msg' => $isFavorite ? 'Fruit marked as favorites' : 'Fruit removed from favorites'];
            // Check if the user has already marked 10 fruits as favorites.
            $favoriteFruitsCount = $this->em->getRepository(Fruit::class)
                ->countFavoriteFruits();
            if ($isFavorite && $favoriteFruitsCount >= 10) {
                return $responose = ['status' => false, 'msg' => 'You can only mark up to 10 fruits as favorites.'];
            }
                
            $fruit->setIsFavorite($isFavorite);
            $this->em->getRepository(Fruit::class)->save($fruit, true);
        }

        return $responose;
    }

    public function getFavoriteFruits(array $searchFields, int $page, int $limit = 10)
    {
        $fruits = $this->em->getRepository(Fruit::class)->findFruits($searchFields, $page, $limit, 1);
        
        $pagination = $this->paginator->paginate($fruits, $page, $limit);
        
        return $pagination;
    }
}
