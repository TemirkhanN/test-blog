<?php

namespace BlogBundle\Repository;

use BlogBundle\Entity\Post;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostRepository extends EntityRepository
{
    /**
     * @param Post $post
     */
    public function savePost(Post $post)
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush($post);
    }

    /**
     * Возвращает пост по идентификатору вместе с данными о авторе поста
     *
     * @param int $postId
     *
     * @return Post|null
     */
    public function getPost(int $postId)
    {
        return $this
            ->createQueryBuilder('postRepository', 'pr')
            ->join('postRepository.author', 'author')
            ->where('postRepository.id = :id')
            ->setParameter('id', $postId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Возвращает список всех постов по простым условиям
     *
     * @param Criteria $criteria
     *
     * @return Paginator
     */
    public function getPosts(Criteria $criteria): Paginator
    {
        $query = $this
            ->createQueryBuilder('postRepository')
            ->select('postRepository')
            ->addCriteria($criteria)
            ->leftJoin('postRepository.author', 'author')
            ->getQuery();

        return new Paginator($query, true);
    }
}
