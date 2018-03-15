<?php

namespace App\Repository;

use App\Entity\DefaultCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DefaultCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DefaultCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DefaultCategory[]    findAll()
 * @method DefaultCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefaultCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DefaultCategory::class);
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
