<?php

// src/AppBundle/Repository/ProductRepository.php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Product;

class ProductRepository extends EntityRepository
{

    public function insert(Product $product)
    {
        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }

    public function getAllQuery()
    {
        $query = $this->createQueryBuilder('p')
                ->orderBy('p.id', 'DESC')
                ->getQuery();
        return $query;
        //return $query->getResult();
    }

}
