<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Author;

use BlogBundle\Controller\AbstractController;
use BlogBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\Blog\Filter\PageFilter;
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
     * @param Author     $author
     * @param PostFilter $postFilter
     * @param PostSort   $postSort
     * @param PageFilter $pageFilter
     *
     * @Extra\ParamConverter("pageFilter");
     * @Extra\ParamConverter("postFilter")
     * @Extra\ParamConverter("postSort");
     *
     * @return Response
     */
    public function execute(Author $author, PageFilter $pageFilter, PostFilter $postFilter = null, PostSort $postSort = null): Response
    {
        $postFilter->setAuthor($author->getId());

        $posts = $this->postService->getList($pageFilter, $postFilter, $postSort);
        $total = $this->postService->count($postFilter);

        return $this->respond('@Blog/post/author-list.html.twig', [
            'author'      => $author,
            'posts'       => $posts,
            'total'       => $total,
            'currentPage' => $pageFilter->getPage(),
            'onPage'      => $pageFilter->getCount(),
        ]);
    }
}
