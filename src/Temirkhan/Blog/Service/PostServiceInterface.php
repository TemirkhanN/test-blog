<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Service;

use Temirkhan\Blog\Entity\PostInterface;
use Temirkhan\Blog\Filter\PageFilter;
use Temirkhan\Blog\Filter\PostFilter;

/**
 * Интерфейс сервиса публикаций
 */
interface PostServiceInterface
{
    /**
     * Добавляет публикацию
     *
     * @param PostInterface $post
     *
     * @return PostInterface
     */
    public function add(PostInterface $post): PostInterface;

    /**
     * Возвращает список публикаций
     *
     * @param PostFilter $filter
     * @param PageFilter $pageFilter
     *
     * @return PostInterface[]
     */
    public function getList(PostFilter $filter, PageFilter $pageFilter): array;

    /**
     * Возвращает количество публикаций
     *
     * @param PostFilter $filter
     *
     * @return int
     */
    public function count(PostFilter $filter): int;
}
