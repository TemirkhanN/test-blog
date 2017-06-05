<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Repository;

use Temirkhan\Blog\Entity\PostInterface;
use Temirkhan\Blog\Filter\PageFilter;
use Temirkhan\Blog\Filter\PostFilter;
use Temirkhan\Blog\Sort\PostSort;

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
     * @param PostFilter|null $postFilter
     *
     * @return int
     */
    public function count(PostFilter $postFilter = null): int;
}
