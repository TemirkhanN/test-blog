<?php

declare(strict_types = 1);

namespace BlogBundle\Repository;

use BlogBundle\Entity\Post;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Temirkhan\Blog\Entity\PostInterface;
use Temirkhan\Blog\Filter\PageFilter;
use Temirkhan\Blog\Filter\PostFilter;
use Temirkhan\Blog\Repository\PostRepositoryInterface;
use Temirkhan\Blog\Sort\PostSort;

/**
 * Репозиторий публикаций
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * Менеджер сущностей
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Конструктор
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Добавляет публикацию в репозиторий
     *
     * @param PostInterface $post
     */
    public function add(PostInterface $post)
    {
        $this->entityManager->getUnitOfWork()->persist($post);
    }

    /**
     * Возвращает список публикаций, удовлетворяющих условию
     *
     * @param PageFilter      $pageFilter
     * @param PostFilter|null $postFilter
     * @param PostSort|null   $postSort
     *
     * @return PostInterface[]
     */
    public function getList(PageFilter $pageFilter, PostFilter $postFilter = null, PostSort $postSort = null): array
    {
        $criteria = $this->getCriteria($postFilter);
        $orderBy  = $this->getOrderBy($postSort);

        return $this->getRepository()->findBy($criteria, $orderBy, $pageFilter->getCount(), $pageFilter->getOffset());
    }

    /**
     * Возвращает количество публикаций, удовлетворяющих условиям
     *
     * @param PostFilter|null $postFilter
     *
     * @return int
     */
    public function count(PostFilter $postFilter = null): int
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('count(p.id)')
            ->from('BlogBundle:Post', 'p');

        if ($criteria = $this->getCriteria($postFilter)) {
            foreach ($criteria as $field => $condition) {
                $queryBuilder
                    ->andWhere(sprintf('p.%s=:%s', $field, $field))
                    ->setParameter($field, $condition);
            }
        }

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * Возвращает репозиторий публикаций
     *
     * @return ObjectRepository
     */
    private function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Post::class);
    }

    /**
     * Формирует и возвращает сортировку
     *
     * @param PostSort|null $postSort
     *
     * @return array|null
     */
    private function getOrderBy(PostSort $postSort = null)
    {
        $sort = null;

        if (!$postSort) {
            return $sort;
        }

        if ($addDateSort = $postSort->getAddDate()) {
            $sort['addDate'] = $addDateSort;
        }

        return $sort;
    }

    /**
     * Формирует и возвращает критерии из фильтров
     *
     * @param PostFilter|null $postFilter
     *
     * @return array
     */
    private function getCriteria(PostFilter $postFilter = null): array
    {
        $criteria = [];

        if (!$postFilter) {
            return $criteria;
        }

        if ($authorId = $postFilter->getAuthor()) {
            $criteria['author'] = $authorId;
        }

        return $criteria;
    }
}
