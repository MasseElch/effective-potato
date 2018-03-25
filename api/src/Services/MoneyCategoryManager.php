<?php

namespace App\Services;

use App\Entity\MoneyAtMonth;
use App\Entity\MoneyCategory;
use Doctrine\ORM\EntityManagerInterface;
use Money\Money;

class MoneyCategoryManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateMoneyCategory(MoneyCategory $moneyCategory, int $year, int $month, Money $money)
    {
        $budgetAtMonth = $this->em->getRepository(MoneyAtMonth::class)
            ->findOneByCategoryYearAndMonth($moneyCategory, $year, $month);

        // If the given month does already have a budget, update it and the categories accordingly.
        // Else create a new one and update the categories.
        if ($budgetAtMonth) {
            // Get the difference
            $diff = $money->subtract($budgetAtMonth->getMoney());

            // Update the budget for the given month
            $budgetAtMonth->setMoney($money);

            $this->updateCategories($moneyCategory, $diff, $year, $month);
        } else {
            $budgetAtMonth = new MoneyAtMonth();
            $budgetAtMonth->setCategory($moneyCategory);
            $budgetAtMonth->setMonth($month);
            $budgetAtMonth->setYear($year);
            $budgetAtMonth->setMoney($money);
            $this->em->persist($budgetAtMonth);

            $this->updateCategories($moneyCategory, $money, $year, $month);
        }

        $this->em->flush();
    }

    private function updateCategories(MoneyCategory $moneyCategory, Money $money, int $year, int $month)
    {
        // Update the category
        $moneyCategory->addMoney($money);

        // Update the default category for the budget
        $defaultCategory = $moneyCategory->getBudget()->getDefaultCategory();
        $defaultCategory->subtractMoney($money);

        // Update the budget for the default category for the given month
        $defaultBudgetAtMonth = $this->em->getRepository(MoneyAtMonth::class)
            ->findOneByCategoryYearAndMonth($defaultCategory, $year, $month);
        $defaultBudgetAtMonth->subtractMoney($money);
    }
}