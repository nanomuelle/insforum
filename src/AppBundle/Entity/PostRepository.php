<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use AppBundle\Entity\Post;

class PostRepository extends EntityRepository {
    const MAX_POST_BY_DEFAULT = 2;

    private function getFindQueryBuilder() {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('p')
            ->from(Post::class, 'p')
            ->orderBy('p.updatedAt', 'DESC');

        return $qb;
    }

    public function findNextNPosts($fromPostId = null, $numberOfPosts = PostRepository::MAX_POST_BY_DEFAULT) {
        $qb = $this->getFindQueryBuilder();

        if ($fromPostId !== null) {
            $qb
                ->where('p.id <= :fromPostId')
                ->setParameter('fromPostId', $fromPostId);
        }

        $query = $qb->getQuery()
            ->setMaxResults($numberOfPosts);

        return $query->getResult();
    }

    public function findAllRecentFirst() {
        return $this->getFindQueryBuilder()->getQuery()
            ->getResult();
    }

    public function getCount() {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select($qb->expr()->count('p.id'))
            ->from('AppBundle:Post', 'p');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
