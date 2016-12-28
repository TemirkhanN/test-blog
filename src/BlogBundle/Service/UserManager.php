<?php
declare(strict_types = 1);

namespace BlogBundle\Service;

use BlogBundle\Entity\User;
use BlogBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class UserManager
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param RequestStack   $requestStack
     * @param UserRepository $userRepository
     */
    public function __construct(RequestStack $requestStack, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function addUser(User $user): User
    {
        return $this->userRepository->addUser($user);
    }

    /**
     * @param string $login
     *
     * @return User|null
     */
    public function getUserByLogin(string $login)
    {
        /**
         * @var User|null $user
         */
        $user = $this->userRepository->findOneBy(['login' => $login]);

        return $user;
    }

    /**
     * @param int $userId
     *
     * @return User|null
     */
    public function getUserById(int $userId)
    {
        /**
         * @var User|null $user
         */
        $user = $this->userRepository->find($userId);

        return $user;
    }
}