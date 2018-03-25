<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\MoneyAtMonth;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MoneyAtMonth|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoneyAtMonth|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoneyAtMonth[]    findAll()
 * @method MoneyAtMonth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyAtMonthRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MoneyAtMonth::class);
    }

    // todo
    public function findByCategoriesYearAndMonth(Collection $categories, int $year, int $month)
    {
        return $this->createQueryBuilder('money_at_month')
            ->where('money_at_month.category in (:categories)')
            ->andWhere('money_at_month.year = :year')
            ->andWhere('money_at_month.month = :month')
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
