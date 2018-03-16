<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Repository\CategoryMoneyAtMonthRepository;
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
     * @param CategoryMoneyAtMonthRepository $categoryMoneyAtMonthRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function categories(Budget $budget, int $year, int $month, CategoryMoneyAtMonthRepository $categoryMoneyAtMonthRepository)
    {
        $defaultCategory = $budget->getDefaultCategory();
        $defaultCategoryBudget = $categoryMoneyAtMonthRepository->findBy(['category' => $defaultCategory, 'year' => $year, 'month' => $month]);

        $categories = $budget->getCategories();
        $categoryBudgets = $categoryMoneyAtMonthRepository->findByCategoriesYearAndMonth($categories, $year, $month);

        return $this->json(
            compact('defaultCategory', 'defaultCategoryBudget', 'categories', 'categoryBudgets'),
            Response::HTTP_OK,
            [],
            ['groups' => ['category_list', 'category_budget_list']]
        );
    }
}
