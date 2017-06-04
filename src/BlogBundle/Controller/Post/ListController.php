<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Post;

use BlogBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\Blog\Filter\PageFilter;
use Temirkhan\Blog\Filter\PostFilter;
use Temirkhan\Blog\Service\PostServiceInterface;

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
     * @param PostFilter $postFilter
     * @param PageFilter $pageFilter
     *
     * @Configuration\ParamConverter("postFilter")
     * @Configuration\ParamConverter("pageFilter");
     *
     * @return Response
     */
    public function execute(PostFilter $postFilter, PageFilter $pageFilter): Response
    {
        $posts = $this->postService->getList($postFilter, $pageFilter);
        $total = $this->postService->count($postFilter);

        return $this->respond('@Blog/post/common-list.html.twig', [
            'posts'  => $posts,
            'total'  => $total,
            'onPage' =>  $pageFilter->getCount(),
        ]);
    }
}
