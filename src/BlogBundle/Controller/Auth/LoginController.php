<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Auth;

use BlogBundle\Controller\AbstractController;
use BlogBundle\Controller\RouterAwareTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Temirkhan\UserBundle\Form\LoginType;
use Temirkhan\UserBundle\Service\AuthService;

/**
 * Контроллер входа в систему
 */
class LoginController extends AbstractController
{
    use RouterAwareTrait;

    /**
     * Сервис аутентификации
     *
     * @var AuthService
     */
    private $authService;

    /**
     * Фабрика форм
     *
     * @var FormFactory
     */
    private $formFactory;

    /**
     * Конструктор
     *
     * @param EngineInterface $engine
     * @param AuthService     $authService
     * @param FormFactory     $formFactory
     */
    public function __construct(EngineInterface $engine, AuthService $authService, FormFactory $formFactory)
    {
        parent::__construct($engine);

        $this->authService = $authService;
        $this->formFactory = $formFactory;
    }

    /**
     * Производит вход в систему
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Security("!is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function execute(Request $request): Response
    {
        $loginForm = $this->formFactory->create(LoginType::class);

        $loginForm->handleRequest($request);

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            try {
                $this->authService->authenticate($loginForm->getData());

                return $this->respondRedirect($this->router->generate('blog_posts'));
            } catch (AuthenticationException $e) {
                $this->addFlashError('Пользователь с такими данными не существует');
            }
        }

        return $this->respond('@Blog/author/login.html.twig', ['loginForm' => $loginForm->createView()]);
    }
}
