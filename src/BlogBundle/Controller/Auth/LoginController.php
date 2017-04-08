<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Auth;

use BlogBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\UserBundle\Form\LoginType;
use Temirkhan\UserBundle\Service\LoginServiceInterface;

/**
 * Контроллер входа в систему
 */
class LoginController extends AbstractController
{
    /**
     * Сервис входа в систему
     *
     * @var LoginServiceInterface
     */
    private $loginService;

    /**
     * Фабрика форм
     *
     * @var FormFactory
     */
    private $formFactory;

    /**
     * Конструктор
     *
     * @param EngineInterface       $engine
     * @param LoginServiceInterface $loginService
     * @param FormFactory           $formFactory
     */
    public function __construct(EngineInterface $engine, LoginServiceInterface $loginService, FormFactory $formFactory)
    {
        parent::__construct($engine);

        $this->loginService = $loginService;
        $this->formFactory  = $formFactory;
    }

    /**
     * Производит вход в систему
     *
     * @param Request $request
     *
     * @return Response
     */
    public function execute(Request $request): Response
    {
        $loginForm = $this->formFactory->create(LoginType::class);

        $loginForm->handleRequest($request);

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            if ($this->loginService->login($loginForm->getData())) {
                return $this->respondRedirect('/blog');
            }

            $this->addFlashError('Пользователя с такими данными не существует');
        }

        return $this->respond('@Blog/user/login.html.twig', ['login_form' => $loginForm->createView()]);
    }
}