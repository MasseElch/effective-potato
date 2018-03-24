<?php
/**
 * Created by PhpStorm.
 * User: jcl
 * Date: 24.03.18
 * Time: 21:54
 */

namespace App\Services;


use App\Entity\BudgetedAtMonth;
use App\Entity\Category;
use App\Entity\DefaultCategory;
use Doctrine\ORM\EntityManagerInterface;
use Money\Money;

class CategoryBudgetService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateCategoryBudget(Category $category, int $year, int $month, Money $money)
    {
        $budgetAtMonth = $this->em->getRepository(BudgetedAtMonth::class)
            ->findOneByCategoryYearAndMonth($category, $year, $month);

        // If the given month does already have a budget, update it and the categories accordingly.
        // Else create a new one and update the categories.
        if ($budgetAtMonth) {
            // Get the difference
            $diff = $money->subtract($budgetAtMonth->getMoney());

            // Update the budget for the given month
            $budgetAtMonth->setMoney($money);

            $this->updateCategoryAndDefaultCategory($category, $diff, $year, $month);
        } else {
            $budgetAtMonth = new BudgetedAtMonth();
            $budgetAtMonth->setCategory($category);
            $budgetAtMonth->setMonth($month);
            $budgetAtMonth->setYear($year);
            $budgetAtMonth->setMoney($money);
            $this->em->persist($budgetAtMonth);

            $this->updateCategoryAndDefaultCategory($category, $money, $year, $month);
        }

        $this->em->flush();
    }

    private function updateCategoryAndDefaultCategory(Category $category, Money $money, int $year, int $month)
    {
        // Update the category
        $category->addMoney($money);

        // Update the default category for the budget
        $defaultCategory = $category->getBudget()->getDefaultCategory();
        $defaultCategory->subtractMoney($money);

        // Update the budget for the default category for the given month
        $defaultBudgetAtMonth = $this->em->getRepository(BudgetedAtMonth::class)
            ->findOneByCategoryYearAndMonth($defaultCategory, $year, $month);
        $defaultBudgetAtMonth->subtractMoney($money);
    }
}