<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Temirkhan\UserBundle\Entity\User;

/**
 * Репозиторий пользователей
 */
class UserRepository
{
    /**
     * Сервис сущностей
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Конструктор
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Добавляет пользователя
     *
     * @param User $user
     */
    public function add(User $user)
    {
        $this->entityManager->persist($user);
    }

    /**
     * Возвращает пользователей, удовлетворяющих условиям
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return User[]
     */
    public function findAll(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return [];
    }

    /**
     * Finds a single object by a set of criteria.
     *
     * @param array $criteria The criteria.
     *
     * @return User|null
     */
    public function findOne(array $criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * Возвращает репозиторий
     *
     * @return ObjectRepository
     */
    private function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(User::class);
    }
}
