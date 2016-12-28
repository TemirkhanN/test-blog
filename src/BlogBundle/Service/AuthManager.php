<?php
declare(strict_types = 1);

namespace BlogBundle\Service;

use BlogBundle\Entity\User;
use \InvalidArgumentException as InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class AuthManager
 * @package BlogBundle\Service
 */
class AuthManager
{
    /**
     * @var string
     */
    private $sessionName = 'current_user_id';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var Router
     */
    private $router;

    /**
     * @param RequestStack $requestStack
     * @param UserManager  $userManager
     * @param Router       $router
     */
    public function __construct(RequestStack $requestStack, UserManager $userManager, Router $router)
    {
        $this->session     = $requestStack->getCurrentRequest()->getSession();
        $this->userManager = $userManager;
        $this->router      = $router;
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->session && $this->session->has($this->sessionName);
    }

    /**
     * @param User $user
     *
     * @return true
     */
    public function login(User $user)
    {
        $dbUser = $this->userManager->getUserByLogin($user->getLogin());
        if ($dbUser && password_verify($user->getPassword(), $dbUser->getPassword())) {
            $dbUser->setLastSigned(new \DateTime());
            $this->saveAuth($dbUser);

            return true;
        }

        return false;
    }

    /**
     * Деавторизовывает пользователя
     */
    public function logout()
    {
        $this->session->remove($this->sessionName);
    }

    /**
     * @param User $user
     */
    public function saveAuth(User $user)
    {
        $this->session->set($this->sessionName, $user->getId());
    }

    /**
     * Регистрирует пользователя в системе
     *
     * @param User $user
     *
     * @return User
     */
    public function registerUser(User $user)
    {
        if ($user->getId()) {
            throw new InvalidArgumentException('Пользователь уже зарегистрирован и существует в системе');
        }
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
        $user->setRegDate(new \DateTime());

        return $this->userManager->addUser($user);
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        if (!$this->isAuthorized()) {
            return null;
        }

        return $this->userManager->getUserById($this->session->get($this->sessionName));
    }

    /**
     * Возвращает ссылку на страницу авторизации
     *
     * @return string
     */
    public function getLoginPageLink(): string
    {
        return $this->router->generate('blog_login');
    }

    /**
     * Возвращает ссылку на страницу деавторизации
     * @return string
     */
    public function getLogoutPageLink(): string
    {
        return $this->router->generate('blog_logout');
    }

    /**
     * Возвращает ссылку на страницу регистрации
     *
     * @return string
     */
    public function getRegisterPageLink(): string
    {
        return $this->router->generate('blog_register');
    }
}