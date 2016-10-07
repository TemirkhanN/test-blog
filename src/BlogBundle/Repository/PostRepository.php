<?php

namespace BlogBundle\Repository;

use BlogBundle\Entity\Post;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class PostRepository
 * @package BlogBundle\Repository
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Возвращает пост по идентификатору вместе с данными о авторе поста
     *
     * @param int $postId
     * @return Post|null
     */
    public function getPost($postId)
    {
        if ($postId < 0) {
            return null;
        }

        return $this
            ->getEntityManager()
            ->createQuery('SELECT p, a FROM BlogBundle:Post p JOIN p.author a WHERE p.id=:id')
            ->setParameter('id', $postId)
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }


    /**
     * Возвращает список всех постов по простым условиям
     *
     * @param array $criteria
     * @param int $page
     * @param int $onPage
     * @param string $orderBy
     * @param string $orderDirection
     *
     * @return Paginator
     */
    public function getPosts($criteria, $page, $onPage, $orderBy = 'pubDate', $orderDirection = 'DESC')
    {
        $page   = $page > 1 ? (int)$page : 1;
        $onPage = $onPage > 1 ? (int)$onPage : 10;
        $offset = ($page - 1) * $onPage;

        $conditions = [];

        foreach($criteria as $column => $value){
            $conditions[] = 'p.' . $column .'= :' . $column;
        }

        $query = $this
            ->getEntityManager()
            ->createQuery('SELECT p, a FROM BlogBundle:Post p JOIN p.author a WHERE ' . implode(' AND ', $conditions) . ' ORDER BY p.' . $orderBy . ' ' . $orderDirection)
            ->setParameters($criteria)
            ->setMaxResults($onPage)
            ->setFirstResult($offset);

        return new Paginator($query);
    }
}
