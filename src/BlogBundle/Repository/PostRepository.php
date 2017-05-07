<?php

declare(strict_types = 1);

namespace BlogBundle\Repository;

use BlogBundle\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

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
     * Добавляет публикаию в репозиторий
     *
     * @param Post $post
     */
    public function add(Post $post)
    {
        $this->entityManager->getUnitOfWork()->persist($post);
    }
}