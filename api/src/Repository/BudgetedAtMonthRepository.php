<?php

namespace App\Repository;

use App\Entity\BudgetedAtMonth;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BudgetedAtMonth|null find($id, $lockMode = null, $lockVersion = null)
 * @method BudgetedAtMonth|null findOneBy(array $criteria, array $orderBy = null)
 * @method BudgetedAtMonth[]    findAll()
 * @method BudgetedAtMonth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetedAtMonthRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BudgetedAtMonth::class);
    }

    // todo
    public function findByCategoriesYearAndMonth(Collection $categories, int $year, int $month)
    {
        return $this->createQueryBuilder('budgetedAtMonth')
            ->where('budgetedAtMonth.category in (:categories)')
            ->andWhere('budgetedAtMonth.year = :year')
            ->andWhere('budgetedAtMonth.month = :month')
            ->setParameter('categories', $categories)
            ->setParameter('year', $year)
            ->setParameter('month', $month)
            ->getQuery()
            ->getResult();
    }

    public function findOneByCategoryYearAndMonth(Category $category, int $year, int $month)
    {
        return $this->findOneBy(['category' => $category, 'year' => $year, 'month' => $month]);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
