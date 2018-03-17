<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Repository\BudgetedAtMonthRepository;
use App\Views\CategoriesView;
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
    public function categories(Budget $budget, int $year, int $month, BudgetedAtMonthRepository $budgetedAtMonthRepository)
    {
        $defaultCategory = $budget->getDefaultCategory();
        $defaultCategoryBudgetAtMonth = $budgetedAtMonthRepository->findOneBy(['category' => $defaultCategory, 'year' => $year, 'month' => $month]);

        $categories = $budget->getCategories();
        $categoryBudgetsAtMonth = $budgetedAtMonthRepository->findByCategoriesYearAndMonth($categories, $year, $month);

        $budgetView = new CategoriesView($defaultCategory, $defaultCategoryBudgetAtMonth, $categories, $categoryBudgetsAtMonth);

        return $this->json($budgetView, Response::HTTP_OK, [], ['groups' => ['category_list', 'budget_at_month_list']]);
    }
}
