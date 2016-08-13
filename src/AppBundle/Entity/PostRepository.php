<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository {
    public function findAllRecentFirst() {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Post p ORDER BY p.updatedAt DESC'
            )
            ->getResult();
    }

    public function getCount() {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select($qb->expr()->count('p.id'))
            ->from('AppBundle:Post', 'p');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
