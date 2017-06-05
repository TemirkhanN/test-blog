<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Service;

use Temirkhan\Blog\Entity\PostInterface;
use Temirkhan\Blog\Filter\PageFilter;
use Temirkhan\Blog\Filter\PostFilter;
use Temirkhan\Blog\Repository\PostRepositoryInterface;
use Temirkhan\Blog\Sort\PostSort;

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
     *
     * @return PostInterface
     */
    public function add(PostInterface $post): PostInterface
    {
        $this->postRepository->add($post);

        return $post;
    }

    /**
     * Возвращает список публикаций
     *
     * @param PageFilter $pageFilter
     * @param PostFilter|null $postFilter
     * @param PostSort|null   $postSort
     *
     * @return PostInterface[]
     */
    public function getList(PageFilter $pageFilter, PostFilter $postFilter = null, PostSort $postSort = null): array
    {
        return $this->postRepository->getList($pageFilter, $postFilter, $postSort);
    }

    /**
     * Возвращает количество публикаций
     *
     * @param PostFilter|null $filter
     *
     * @return int
     */
    public function count(PostFilter $filter = null): int
    {
        return $this->postRepository->count($filter);
    }
}
