<?php

namespace App\Repository;

use App\Entity\CategoryBudgetAtMonth;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoryBudgetAtMonth|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryBudgetAtMonth|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryBudgetAtMonth[]    findAll()
 * @method CategoryBudgetAtMonth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryBudgetAtMonthRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoryBudgetAtMonth::class);
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
