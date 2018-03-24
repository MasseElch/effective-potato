<?php

namespace App\Controller;

use App\Entity\BudgetedAtMonth;
use App\Entity\Category;
use App\Services\CategoryBudgetService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Money\Currency;
use Money\Money;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CategoryController
 * @package App\Controller
 *
 * @Route("/categories")
 */
class CategoryController extends Controller
{
    /**
     * @Rest\Patch("/{id}/{year}/{month}")
     *
     * @param Request $request
     * @param Category $category
     * @param int $year
     * @param int $month
     * @param CategoryBudgetService $categoryBudgetService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateCategoryBudget(Request $request, Category $category, int $year, int $month, CategoryBudgetService $categoryBudgetService)
    {
        // Create the money
        $money = $request->request->get('money');
        $money = new Money($money['amount'], new Currency($money['currency']));

        $categoryBudgetService->updateCategoryBudget($category, $year, $month, $money);

        return $this->json($category, Response::HTTP_OK, [], ['groups' => ['budget_detail', 'budget_at_month_list']]);
    }
}
