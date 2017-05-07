<?php

declare(strict_types = 1);

namespace BlogBundle\Repository;

use BlogBundle\Entity\Post;

/**
 * Интерфейс репозитория публикаций
 */
interface PostRepositoryInterface
{
    /**
     * Добавляет публикаию в репозиторий
     *
     * @param Post $post
     */
    public function add(Post $post);
}