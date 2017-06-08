<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Post;

use BlogBundle\Controller\AbstractController;
use BlogBundle\Controller\RouterAwareTrait;
use BlogBundle\Entity\Author;
use BlogBundle\Entity\Post;
use BlogBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as  Extra;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\Blog\Service\PostServiceInterface;

/**
 * Контроллер добавления публикации
 */
class CreateController extends AbstractController
{
    use RouterAwareTrait;

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
     * Конструктор
     *
     * @param EngineInterface      $engine
     * @param FormFactoryInterface $formFactory
     * @param PostServiceInterface $postService
     */
    public function __construct(
        EngineInterface $engine,
        FormFactoryInterface $formFactory,
        PostServiceInterface $postService
    ) {
        parent::__construct($engine);

        $this->formFactory   = $formFactory;
        $this->postService   = $postService;
    }

    /**
     * Создает публикацию
     *
     * @param Request $request
     * @param Author  $currentAuthor
     *
     * @return Response
     *
     * @Extra\ParamConverter("author")
     * @Extra\Security("has_role('ROLE_AUTHOR')")
     */
    public function execute(Request $request, Author $currentAuthor): Response
    {
        $post = new Post($currentAuthor);
        $form = $this->formFactory->create(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $this->postService->addPost($form->getData());

            return $this->respondRedirect($this->router->generate('blog_post', ['post' => $post->getId()]));
        }

        return $this->respond('@Blog/post/item-form.html.twig', ['postForm' => $form->createView()]);
    }
}
