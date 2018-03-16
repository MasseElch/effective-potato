<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Security\Voter\BudgetVoter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BudgetController
 * @package App\Controller
 *
 * @Route("/budgets")
 */
class BudgetController extends Controller
{
    /**
     * @Rest\Get("/{id}")
     * @param Budget $budget
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function budget(Budget $budget)
    {
        $this->denyAccessUnlessGranted(BudgetVoter::VIEW, $budget);

        return $this->json($budget, Response::HTTP_OK, [], ['groups' => ['budget_details', 'account_list', 'budget_ownership_list', 'user_list']]);
    }
}
