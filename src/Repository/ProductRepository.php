<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Product[] Returns an array of Product list ordered by annual price with the most expensive package first. 
    */
   public function findAll(): array
   {
       return $this->createQueryBuilder('p')
           ->addSelect("CASE WHEN p.subscription = 'Months' THEN p.price*12 ELSE p.price END AS annual_price")
           ->orderBy('annual_price', 'DESC')
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return product based on title value
    */
   public function findOneByTitle($value)
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.title = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
