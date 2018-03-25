<?php

namespace App\Tests;


use App\Entity\Budget;
use App\Entity\DefaultCategory;
use App\Entity\MoneyAtMonth;
use App\Entity\MoneyCategory;
use Cake\Chronos\Chronos;
use Money\Currency;
use Money\Money;
use Symfony\Component\HttpFoundation\Response;

class CategoryControllerTest extends ControllerTest
{
    public function testCategoryMoneyUpdate()
    {
        $client = static::createAuthenticatedClient();
        $em = $client->getContainer()->get('doctrine')->getManager();

        // Current date
        $date = Chronos::now();

        // Get an owned budget
        $budget = $this->getUser()->getBudgetOwnerships()[0]->getBudget();

        // Get a category
        $category = $budget->getMoneyCategories()[0];

        $client->request(
            'patch',
            implode('/', ['/api/categories', $category->getId(), $date->year, $date->month]),
            [
                'money' => [
                    'amount' => 300,
                    'currency' => 'EUR'
                ]
            ]
        );

        self::assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            $client->getResponse()->getContent()
        );

        // Check if the moneyCategory got updated
        $money = $em->find(MoneyCategory::class, $category->getId())->getMoney();
        self::assertTrue($money->equals(new Money(300, new Currency('EUR'))));

        // Check if the MoneyAtMonth for the given category was updated
        $money = $em->getRepository(MoneyAtMonth::class)->findOneBy([
            'category' => $category->getId(),
            'year' => $date->year,
            'month' => $date->month
        ])->getMoney();
        self::assertTrue($money->equals(new Money(300, new Currency('EUR'))));

        // Check if the defaultCategory got updated
        $defaultCategory = $em->getRepository(DefaultCategory::class)
            ->findOneBy(['budget' => $budget->getId()]);
        self::assertTrue($defaultCategory->getMoney()->equals(new Money(99700, new Currency('EUR'))));

        // Check if the MoneyAtMonth for the given defaultCategory was updated
        $money = $em->getRepository(MoneyAtMonth::class)->findOneBy([
            'category' => $defaultCategory->getId(),
            'year' => $date->year,
            'month' => $date->month
        ])->getMoney();
        self::assertTrue($money->equals(new Money(99700, new Currency('EUR'))));
    }

    public function testCanOnlyEditOwnedBudget()
    {
        $client = static::createAuthenticatedClient();
        $em = $client->getContainer()->get('doctrine')->getManager();

        // Current date
        $date = Chronos::now();

        // Get a not owned budget
        $notOwnedbudgets = $em->getRepository(Budget::class)
            ->createQueryBuilder('budget')
            ->select('budget')
            ->join('budget.budgetOwnerships', 'budgetOwnership')
            ->join('budgetOwnership.user', 'user')
            ->where('user <> :user')
            ->setParameter('user', $this->getUser())
            ->getQuery()
            ->getResult()
        ;

        // A category from the budget the user does not own
        $notOwnedCategory = $notOwnedbudgets[0]->getMoneyCategories()[0];

        $client->request(
            'patch',
            implode('/', ['/api/categories', $notOwnedCategory->getId(), $date->year, $date->month]),
            [
                'money' => [
                    'amount' => 300,
                    'currency' => 'EUR'
                ]
            ]
        );

        self::assertSame(
            Response::HTTP_FORBIDDEN,
            $client->getResponse()->getStatusCode(),
            $client->getResponse()->getContent()
        );
    }
}
