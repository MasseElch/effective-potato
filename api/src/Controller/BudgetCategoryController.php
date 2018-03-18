<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\BudgetedAtMonth;
use App\Repository\BudgetedAtMonthRepository;
use App\Views\CategoryBudgets;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BudgetCategoryController
 * @package App\Controller
 *
 * @Route("/budgets")
 */
class BudgetCategoryController extends Controller
{
    /**
     * @Rest\Get("/{id}/categories/{year}/{month}")
     *
     * @param Budget $budget
     * @param int $year
     * @param int $month
     * @param BudgetedAtMonthRepository $budgetedAtMonthRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function categoryBudgets(Budget $budget, int $year, int $month, BudgetedAtMonthRepository $budgetedAtMonthRepository)
    {
        $categories = $budget->getCategories();
        $categories[] = $budget->getDefaultCategory();

        $categoryBudgets = [];
        foreach ($budgetedAtMonthRepository->findByCategoriesYearAndMonth($categories, $year, $month) as $budgetedAtMonth) {
            /** @var BudgetedAtMonth $budgetedAtMonth */
            $categoryBudgets[$budgetedAtMonth->getCategory()->getId()] = $budgetedAtMonth;
        }

        return $this->json($categoryBudgets, Response::HTTP_OK, [], ['groups' => ['budget_at_month_list']]);
    }
}
