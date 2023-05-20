<?php

namespace App\Controller;

use App\Service\FruitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Fruit;

class FruitController extends AbstractController
{
  
    /**
     * @param Request $request
     * @param FruitService $fruitService
     *
     * @return Response
     */
    #[Route('/fruit/list', name: 'fruit_list')]
    public function list(Request $request, FruitService $fruitService): Response
    {
        $page = $request->query->getInt('page', 1);
        $name = $request->query->get('name');
        $family = $request->query->get('family');
        $searchFields = [
          'name' => $request->query->get('name'),
          'family' => $request->query->get('family'),
        ];
        
        $pagination = $fruitService->getFruits($searchFields, $page);

        return $this->render('fruit/list.html.twig', [
            'pagination' => $pagination,
            'name' => $name,
            'family' => $family,
        ]);
    }

   
    /**
     * @param Request $request
     * @param Fruit $fruit
     * @param FruitService $fruitService
     *
     * @return JsonRespone
     */
    #[Route('/fruit/{id}/favorite', name: 'mark_favorite', methods: ['POST'])]
    public function markFavorite(int $id, Request $request, FruitService $fruitService)
    {
        $payload = json_decode($request->getContent(), true);
        $isFavorite = $payload['isFavorite'];
        $status = $fruitService->markFavorite($id, $isFavorite);

        return new JsonResponse($status);
    }

    /**
     * @param Request $request
     * @param FruitService $fruitService
     *
     * @return Response
     */
    #[Route('/favorite/fruit/list', name: 'fav_fruit_list')]
    public function favoriteFruitList(Request $request, FruitService $fruitService): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $fruitService->getFavoriteFruits([], $page);

        return $this->render('fruit/favorite-list.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
