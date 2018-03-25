<?php

namespace App\Repository;

use App\Entity\DefaultMoneyCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DefaultMoneyCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DefaultMoneyCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DefaultMoneyCategory[]    findAll()
 * @method DefaultMoneyCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefaultCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DefaultMoneyCategory::class);
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
