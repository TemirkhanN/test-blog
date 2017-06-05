<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Service;

use Temirkhan\Blog\Entity\PostInterface;
use Temirkhan\Blog\Filter\PageFilter;
use Temirkhan\Blog\Filter\PostFilter;
use Temirkhan\Blog\Sort\PostSort;

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
     * @param PageFilter      $pageFilter
     * @param PostFilter|null $filter
     * @param PostSort|null   $postSort
     *
     * @return PostInterface[]
     */
    public function getList(PageFilter $pageFilter, PostFilter $filter = null, PostSort $postSort = null): array;

    /**
     * Возвращает количество публикаций
     *
     * @param PostFilter|null $filter
     *
     * @return int
     */
    public function count(PostFilter $filter = null): int;
}
