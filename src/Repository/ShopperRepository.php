<?php

namespace App\Repository;

use App\Entity\Shopper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Shopper|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shopper|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shopper[]    findAll()
 * @method Shopper[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shopper::class);
    }

}
