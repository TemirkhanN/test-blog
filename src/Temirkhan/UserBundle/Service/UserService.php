<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Temirkhan\UserBundle\Repository\UserRepository;
use Temirkhan\UserBundle\ValueObject\LoginData;

/**
 * Сервис входа в систему
 */
class UserService implements LoginServiceInterface, LogoutServiceInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Конструктор
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Производит вход в систему
     *
     * @param LoginData $loginData
     *
     * @return bool
     */
    public function login(LoginData $loginData): bool
    {
        $user = $this->userRepository->findOne(['login' => $loginData->getLogin()]);

        if (!$user) {
            return false;
        }

        if (!password_verify($loginData->getPassword(), $user->getPassword())) {
            return false;
        }

        // TODO сделать что-то нормальное(oauth, это ты?)
        $session = new Session();
        $session->set('user', $user);
        $session->save();

        return true;
    }

    /**
     * Производит выход из системы
     */
    public function logout()
    {

    }
}