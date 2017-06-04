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
     * @param PostFilter $postFilter
     * @param PageFilter $pageFilter
     *
     * @return PostInterface[]
     */
    public function getList(PostFilter $postFilter, PageFilter $pageFilter): array
    {
        return $this->getRepository()->findBy([]);
    }

    /**
     * Возвращает количество публикаций, удовлетворяющих условиям
     *
     * @param PostFilter $postFilter
     *
     * @return int
     */
    public function count(PostFilter $postFilter): int
    {
        return $this->entityManager->createQueryBuilder()
            ->select('count(p.id)')
            ->from('BlogBundle:Post', 'p')
            ->getQuery()
            ->getSingleScalarResult();
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
}
