<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Repository;

use Temirkhan\Blog\Entity\PostInterface;

/**
 * Интерфейс репозитория публикаций
 */
interface PostRepositoryInterface
{
    /**
     * Добавляет публикацию в репозиторий
     *
     * @param PostInterface $post
     */
    public function add(PostInterface $post);
}