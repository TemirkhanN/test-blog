<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Service;

use Temirkhan\Blog\Entity\PostInterface;

/**
 * Интерфейс сервиса публикаций
 */
interface PostServiceInterface
{
    /**
     * Добавляет публикацию
     *
     * @param PostInterface $post
     */
    public function add(PostInterface $post);
}