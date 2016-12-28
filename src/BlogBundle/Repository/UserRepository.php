<?php
declare(strict_types = 1);

namespace BlogBundle\Repository;


use BlogBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Репозиторий для работы с пользователями
 */
class UserRepository extends EntityRepository
{
    /**
     * @param User $user
     *
     * @return User
     */
    public function addUser(User $user): User
    {
        $this->getEntityManager()->persist($user);

        return $user;
    }
    /**
     * @param User $user
     *
     * @return void
     */
    public function updateUser(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }
}