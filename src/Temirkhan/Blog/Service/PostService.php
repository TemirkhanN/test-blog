<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Service;

use Temirkhan\Blog\Entity\PostInterface;
use Temirkhan\Blog\Filter\PageFilter;
use Temirkhan\Blog\Filter\PostFilter;
use Temirkhan\Blog\Repository\PostRepositoryInterface;

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
     * @param PostFilter $postFilter
     * @param PageFilter $pageFilter
     *
     * @return PostInterface[]
     */
    public function getList(PostFilter $postFilter, PageFilter $pageFilter): array
    {
        return $this->postRepository->getList($postFilter, $pageFilter);
    }

    /**
     * Возвращает количество публикаций
     *
     * @param PostFilter $filter
     *
     * @return int
     */
    public function count(PostFilter $filter): int
    {
        return $this->postRepository->count($filter);
    }
}
