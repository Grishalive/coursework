<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function findAllOrderedByID()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Category p ORDER BY p.id ASC'
            )
            ->getResult();
    }
}
