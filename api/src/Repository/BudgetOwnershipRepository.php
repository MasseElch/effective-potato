<?php

namespace App\Repository;

use App\Entity\BudgetOwnership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BudgetOwnership|null find($id, $lockMode = null, $lockVersion = null)
 * @method BudgetOwnership|null findOneBy(array $criteria, array $orderBy = null)
 * @method BudgetOwnership[]    findAll()
 * @method BudgetOwnership[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetOwnershipRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BudgetOwnership::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('b')
            ->where('b.something = :value')->setParameter('value', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
