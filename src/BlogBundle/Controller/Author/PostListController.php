<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Author;

use BlogBundle\Controller\AbstractController;
use BlogBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\Blog\Filter\Page;
use Temirkhan\Blog\Filter\PostFilter;
use Temirkhan\Blog\Service\PostServiceInterface;
use Temirkhan\Blog\Sort\PostSort;

/**
 * Контроллер списка публикаций автора
 */
class PostListController extends AbstractController
{
    /**
     * Сервис публикаций
     *
     * @var PostServiceInterface
     */
    private $postService;

    /**
     * Конструктор
     *
     * @param EngineInterface      $engine
     * @param PostServiceInterface $postService
     */
    public function __construct(EngineInterface $engine, PostServiceInterface $postService)
    {
        parent::__construct($engine);

        $this->postService = $postService;
    }

    /**
     * Просмотр публикаций автора
     *
     * @param Author        $author
     * @param Page          $page
     * @param PostFilter    $postFilter
     * @param PostSort|null $postSort
     *
     * @return Response
     *
     * @Extra\ParamConverter("author")
     * @Extra\ParamConverter("postFilter")
     * @Extra\ParamConverter("postSort")
     */
    public function execute(
        Author $author,
        Page $page,
        PostFilter $postFilter,
        PostSort $postSort = null
    ): Response {
        $posts = $this->postService->getAuthorPosts($author, $page, $postFilter, $postSort);
        $total = $this->postService->getAuthorPostsCount($author, $postFilter);

        return $this->respond('@Blog/post/author-list.html.twig', [
            'author' => $author,
            'posts'  => $posts,
            'total'  => $total,
            'page'   => $page,
            'sort'   => $postSort,
        ]);
    }
}
