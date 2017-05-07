<?php

declare(strict_types = 1);

namespace BlogBundle\Service;

use BlogBundle\Entity\Post;
use BlogBundle\Repository\PostRepositoryInterface;

/**
 * Сервис публикаций
 */
class PostService implements PostServiceInterface
{
    /**
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
     * @param Post $post
     *
     * @return Post
     */
    public function add(Post $post): Post
    {
        $this->postRepository->add($post);

        return $post;
    }
}