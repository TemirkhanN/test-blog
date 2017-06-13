<?php

declare(strict_types=1);

namespace BlogBundle\Controller\Author;

use BlogBundle\Controller\AbstractController;
use BlogBundle\Controller\RouterAwareTrait;
use BlogBundle\Form\RegistrationType;
use BlogBundle\Service\AuthorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Контроллер регистрации автора
 */
class RegisterController extends AbstractController
{
    use RouterAwareTrait;

    /**
     * Фабрика форм
     *
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * Сервис авторов
     *
     * @var AuthorService
     */
    private $authorService;

    /**
     * Конструктор
     *
     * @param EngineInterface      $engine
     * @param FormFactoryInterface $formFactory
     * @param AuthorService        $authorService
     */
    public function __construct(
        EngineInterface $engine,
        FormFactoryInterface $formFactory,
        AuthorService $authorService
    ) {
        parent::__construct($engine);

        $this->formFactory   = $formFactory;
        $this->authorService = $authorService;
    }

    /**
     * Регистрация автора
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Security("!is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function execute(Request $request): Response
    {
        $form = $this->formFactory->create(RegistrationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->authorService->registerAuthor($form->getData());

                return $this->respondRedirect($this->router->generate('blog.login'));
            } catch (Throwable $e) {
                $this->addFlashError('Произошла непредвиденная ошибка');
            }
        }

        return $this->respond('@Blog/author/register.html.twig', ['registrationForm' => $form->createView()]);
    }
}
