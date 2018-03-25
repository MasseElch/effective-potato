<?php

namespace App\Controller;

use App\Entity\MoneyCategory;
use App\Security\Voter\CategoryVoter;
use App\Services\MoneyCategoryManager;
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
     * @param MoneyCategory $moneyCategory
     * @param int $year
     * @param int $month
     * @param MoneyCategoryManager $categoryMoneyService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateCategoryMoney(Request $request, MoneyCategory $moneyCategory, int $year, int $month, MoneyCategoryManager $categoryMoneyService)
    {
        $this->denyAccessUnlessGranted(CategoryVoter::EDIT, $moneyCategory);

        // Create the money
        $money = $request->request->get('money');
        $money = new Money($money['amount'], new Currency($money['currency']));

        $categoryMoneyService->updateMoneyCategory($moneyCategory, $year, $month, $money);

        return $this->json($moneyCategory, Response::HTTP_OK, [], ['groups' => ['budget_detail', 'budget_at_month_list']]);
    }
}
