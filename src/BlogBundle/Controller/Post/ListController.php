<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Post;

use BlogBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\Blog\Filter\Page;
use Temirkhan\Blog\Filter\PostFilter;
use Temirkhan\Blog\Service\PostServiceInterface;
use Temirkhan\Blog\Sort\PostSort;

/**
 * Контроллер просмотра списка публикаций
 */
class ListController extends AbstractController
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
     * Просмотр публикаций
     *
     * @param Page       $page
     * @param PostFilter $postFilter
     * @param PostSort   $postSort
     *
     * @return Response
     *
     * @Extra\ParamConverter("postFilter")
     * @Extra\ParamConverter("postSort");
     */
    public function execute(Page $page, PostFilter $postFilter, PostSort $postSort = null): Response
    {
        $posts = $this->postService->getPosts($page, $postFilter, $postSort);
        $total = $this->postService->getPostsCount($postFilter);

        return $this->respond('@Blog/post/common-list.html.twig', [
            'posts' => $posts,
            'total' => $total,
            'page'  => $page,
            'sort'  => $postSort,
        ]);
    }
}
