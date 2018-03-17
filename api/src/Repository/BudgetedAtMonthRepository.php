<?php

namespace App\Repository;

use App\Entity\BudgetedAtMonth;
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

    public function findByCategoriesYearAndMonth(Collection $categories, int $year, int $month) {
        return $this->createQueryBuilder('cbam')
            ->where('cbam.category in (:categories)')
            ->setParameter('categories', $categories)
            ->getQuery()
            ->getResult()
        ;
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
