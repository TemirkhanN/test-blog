<?php

declare(strict_types=1);

namespace Temirkhan\UserBundle\Provider;


use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Temirkhan\UserBundle\Entity\User;
use Temirkhan\UserBundle\Repository\UserRepository;

/**
 * Провайдер пользователей
 */
class UserProvider implements UserProviderInterface
{
    /**
     * Репозиторий пользователей
     *
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
     * Возвращает пользователя по имени
     *
     * @param string $username
     *
     * @return UserInterface
     */
    public function loadUserByUsername($username)
    {
        $user =$this->userRepository->findOne(['login' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        return $user;
    }

    /**
     * Обновляет пользователя
     *
     * @param UserInterface  $user
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * Возвращает поддержку переданного класса
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        if ($class === User::class) {
            return true;
        }

        return false;
    }
}