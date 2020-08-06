<?php

namespace App\Repository;

use App\Entity\ProductCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductCatalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductCatalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductCatalog[]    findAll()
 * @method ProductCatalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductCatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCatalog::class);
    }

}
