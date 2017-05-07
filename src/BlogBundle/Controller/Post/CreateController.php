<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Post;

use BlogBundle\Controller\AbstractController;
use BlogBundle\Form\PostType;
use BlogBundle\Service\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

/**
 * Контроллер добавления публикации
 */
class CreateController extends AbstractController
{
    /**
     * Фабрика форм
     *
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * Сервис публикаций
     *
     * @var PostServiceInterface
     */
    private $postService;

    /**
     * Маршрутизатор
     *
     * @var Router
     */
    private $router;

    /**
     * Конструктор
     *
     * @param EngineInterface      $engine
     * @param FormFactoryInterface $formFactory
     * @param PostServiceInterface $postService
     */
    public function __construct(
        EngineInterface $engine,
        FormFactoryInterface $formFactory,
        PostServiceInterface $postService,
        Router $router
    ) {
        parent::__construct($engine);

        $this->formFactory = $formFactory;
        $this->postService = $postService;
        $this->router      = $router;
    }

    /**
     * Создает публикацию
     *
     * @return Response
     */
    public function execute(Request $request): Response
    {
        $form = $this->formFactory->create(PostType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $this->postService->add($form->getData());

            return $this->respondRedirect($this->router->generate('blog_post', ['post' => $post->getId()]));
        }

        return $this->respond('@Blog/post/item-form.html.twig', ['postForm' => $form]);
    }
}
