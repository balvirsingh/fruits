<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GiftAssignmentService;
use App\Entity\Employee;

class GiftAssignmentController extends AbstractController
{
    #[Route('/employee/{employeeId}/gift/assignment', name: 'app_gift_assignment')]
    /**
     * @param $employeeId
     * @param GiftAssignmentService $giftAssignmentService
     *
     * @return JsonResponse
     */
    public function index($employeeId, GiftAssignmentService $giftAssignmentService): JsonResponse
    {
        $response = $giftAssignmentService->fetchAndAssignGiftToEmployee($employeeId);

        return $this->json([
            'response' => $response,
        ]);
    }
}
