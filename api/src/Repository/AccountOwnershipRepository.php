<?php

namespace App\Repository;

use App\Entity\AccountOwnership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AccountOwnership|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountOwnership|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountOwnership[]    findAll()
 * @method AccountOwnership[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountOwnershipRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AccountOwnership::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.something = :value')->setParameter('value', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
