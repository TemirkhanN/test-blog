<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Service;

use Temirkhan\Blog\Entity\AuthorInterface;
use Temirkhan\Blog\Entity\PostInterface;
use Temirkhan\Blog\Filter\Page;
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
    public function addPost(PostInterface $post): PostInterface
    {
        $this->postRepository->add($post);

        return $post;
    }

    /**
     * Возвращает список публикаций
     *
     * @param Page            $pageFilter
     * @param PostFilter|null $filter
     * @param PostSort|null   $postSort
     *
     * @return PostInterface[]
     */
    public function getPosts(Page $pageFilter, PostFilter $filter, PostSort $postSort = null): array
    {
        $filter->setStatus(PostInterface::STATUS_PUBLISHED);

        return $this->postRepository->getList($pageFilter, $filter, $postSort);
    }

    /**
     * Возвращает количество публикаций
     *
     * @param PostFilter $filter
     *
     * @return int
     */
    public function getPostsCount(PostFilter $filter): int
    {
        $filter->setStatus(PostInterface::STATUS_PUBLISHED);

        return $this->postRepository->count($filter);
    }

    /**
     * Возвращает список публикаций автора
     *
     * @param AuthorInterface $author
     * @param Page            $pageFilter
     * @param PostFilter      $filter
     * @param PostSort|null   $postSort
     *
     * @return PostInterface[]
     */
    public function getAuthorPosts(
        AuthorInterface $author,
        Page $pageFilter,
        PostFilter $filter,
        PostSort $postSort = null
    ): array {
        $filter->setAuthor($author->getId());

        return $this->getPosts($pageFilter, $filter, $postSort);
    }

    /**
     * Возвращает количество публикаций автора
     *
     * @param AuthorInterface $author
     * @param PostFilter      $filter
     *
     * @return int
     */
    public function getAuthorPostsCount(AuthorInterface $author, PostFilter $filter): int
    {
        $filter->setAuthor($author->getId());

        return $this->getPostsCount($filter);
    }
}
