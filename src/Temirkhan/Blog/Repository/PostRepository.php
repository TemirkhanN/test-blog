<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Temirkhan\Blog\Entity\PostInterface;

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
}