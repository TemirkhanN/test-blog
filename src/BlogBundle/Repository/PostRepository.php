<?php

declare(strict_types = 1);

namespace Temirkhan\BlogBundle\Repository;

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
     * Возвращает репозиторий публикаций
     *
     * @return ObjectRepository
     */
    private function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Post::class);
    }
}
