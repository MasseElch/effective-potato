<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BudgetRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserBudgetController
 * @package App\Controller
 *
 * @Route("/users")
 */
class UserBudgetController extends Controller
{
    /**
     * @Rest\Get("/{id}/budgets")
     *
     * @param User $user
     * @param BudgetRepository $budgetRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function budgets(User $user, BudgetRepository $budgetRepository)
    {
        return $this->json($budgetRepository->findByUser($user), 200, [], ['groups' => ['budget_list']]);
    }
}
