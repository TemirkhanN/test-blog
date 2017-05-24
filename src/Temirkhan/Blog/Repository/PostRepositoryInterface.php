<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Repository;

use Temirkhan\Blog\Entity\PostInterface;
use Temirkhan\Blog\Filter\PageFilter;
use Temirkhan\Blog\Filter\PostFilter;

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

    /**
     * Возвращает список публикаций
     *
     * @param PostFilter $postFilter
     * @param PageFilter $pageFilter
     *
     * @return PostInterface[]
     */
    public function getList(PostFilter $postFilter, PageFilter $pageFilter): array;
}
