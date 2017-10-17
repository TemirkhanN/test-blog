<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Service;

use DateTime;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Temirkhan\UserBundle\Entity\User;
use Temirkhan\UserBundle\Repository\UserRepository;
use Temirkhan\UserBundle\ValueObject\RegistrationCredentials;

/**
 * Сервис пользователей
 */
class UserService
{
    /**
     * Репозиторий пользователей
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Шифратор паролей
     *
     * @var EncoderFactoryInterface
     */
    private $passwordEncoder;

    /**
     * Конструктор
     *
     * @param UserRepository          $userRepository
     * @param EncoderFactoryInterface $passwordEncoder
     */
    public function __construct(UserRepository $userRepository, EncoderFactoryInterface $passwordEncoder)
    {
        $this->userRepository  = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Регистрирует нового пользователя
     *
     * @param RegistrationCredentials $credentials
     *
     * @return User
     */
    public function registerUser(RegistrationCredentials $credentials): User
    {
        $user = new User(new DateTime());

        $password = $this->passwordEncoder
            ->getEncoder($user)
            ->encodePassword($credentials->getPassword(), $user->getSalt());

        $user->setLogin($credentials->getLogin());
        $user->setPassword($password);

        $this->userRepository->add($user);

        return $user;
    }
}
