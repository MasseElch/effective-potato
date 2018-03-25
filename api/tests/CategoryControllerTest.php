<?php

namespace App\Tests;


use App\Entity\Budget;
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

        // Get a category
        $category = $this->getUser()->getBudgetOwnerships()[0]->getBudget()->getMoneyCategories()[0];

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

        $money = $em->find(MoneyCategory::class, $category->getId())->getMoney();
        self::assertTrue($money->equals(new Money(300, new Currency('EUR'))));
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
