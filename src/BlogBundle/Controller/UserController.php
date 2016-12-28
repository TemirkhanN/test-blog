<?php

namespace BlogBundle\Controller;

use BlogBundle\Form\LoginType;
use BlogBundle\Form\RegisterType;
use BlogBundle\Service\AuthManager;
use BlogBundle\Service\PostManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Контроллер для манипуляций с пользователем
 */
class UserController extends AbstractController
{
    /**
     *
     * @var Session
     */
    private $session;

    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * @var PostManager
     */
    private $postManager;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @param EngineInterface $engine
     * @param AuthManager     $authManager
     * @param PostManager     $postManager
     * @param FormFactory     $formFactory
     */
    public function __construct(
        EngineInterface $engine,
        AuthManager $authManager,
        PostManager $postManager,
        FormFactory $formFactory
    )
    {
        $this->session     = new Session();
        $this->authManager = $authManager;
        $this->postManager = $postManager;
        $this->formFactory = $formFactory;
        $this->setRenderer($engine);
    }

    /**
     * Вход в систему
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function loginAction(Request $request)
    {
        //Перенаправление пользователя. Явное-передан ?returnTo. По-умолчанию - главная страница блога)
        $returnTo = $request->query->get('returnTo') ?: $this->postManager->getPostsPageLink();

        //Если пользователь уже авторизован, перебрасываем его на главную страницу блога
        if ($this->authManager->isAuthorized()) {
            return $this->respondRedirect($returnTo);
        }

        $loginForm = $this->formFactory->create(LoginType::class);
        $loginForm->handleRequest($request);

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            if ($this->authManager->login($loginForm->getData())) {
                return $this->respondRedirect($returnTo);
            } else {
                $this->session
                    ->getFlashBag()
                    ->add('error', 'Пользователя с такими данными не существует');
            }
        }

        return $this->respond('BlogBundle:user:login.html.twig', ['login_form' => $loginForm->createView()]);
    }

    /**
     * Выход из системы
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function logoutAction(Request $request): RedirectResponse
    {
        $returnTo = $request->query->get('returnTo') ?: $this->postManager->getPostsPageLink();

        $this->authManager->logout();

        return $this->respondRedirect($returnTo);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function registerAction(Request $request)
    {
        //Если пользователь уже авторизован, перебрасываем его на главную страницу блога
        if ($this->authManager->isAuthorized()) {
            return $this->respondRedirect($this->postManager->getPostsPageLink());
        }

        $form = $this->formFactory->create(RegisterType::class, null, ['validation_groups' => ['register']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authManager->registerUser($form->getData());

            return $this->respondRedirect($this->authManager->getLoginPageLink());
        }

        return $this->respond('BlogBundle:user:register.html.twig', ['register_form' => $form->createView()]);
    }
}
