<?php

namespace App\Repository;

use App\Entity\MoneyCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MoneyCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoneyCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoneyCategory[]    findAll()
 * @method MoneyCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MoneyCategory::class);
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
