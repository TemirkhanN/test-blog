<?php

declare(strict_types = 1);

namespace BlogBundle\Service;

use BlogBundle\Entity\Post;

/**
 * Интерфейс сервиса публикаций
 */
interface PostServiceInterface
{
    /**
     * Добавляет публикацию
     *
     * @param Post $post
     *
     * @return Post
     */
    public function add(Post $post): Post;
}