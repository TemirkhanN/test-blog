<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Controller;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\UserBundle\Form\LoginType;
use Temirkhan\UserBundle\Service\LoginServiceInterface;

/**
 * Контроллер входа в систему
 */
class LoginController
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
     * @param LoginServiceInterface $loginService
     * @param FormFactory           $formFactory
     */
    public function __construct(LoginServiceInterface $loginService, FormFactory $formFactory)
    {
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
    public function login(Request $request): Response
    {
        $loginForm = $this->formFactory->create(LoginType::class);

        $loginForm->handleRequest($request);

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            return $this->loginService->login($loginForm->getData());
        }

        return new Response();
    }
}