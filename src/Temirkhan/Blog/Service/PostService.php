<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Service;

use BlogBundle\Repository\PostRepositoryInterface;
use Temirkhan\Blog\Entity\PostInterface;

/**
 * Сервис публикаций
 */
class PostService implements PostServiceInterface
{
    /**
     * Репозиторий публикаций
     *
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * Конструктор
     *
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Добавляет публикацию
     *
     * @param PostInterface $post
     */
    public function add(PostInterface $post)
    {
        $this->postRepository->add($post);
    }
}