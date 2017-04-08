<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Persisters\Entity\EntityPersister;
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
        // TODO: Implement findBy() method.
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
        /**
         * @var User|null $user
         */
        $user = $this->getPersister()->load($criteria);

        return $user;
    }

    /**
     * Возвращает persister
     *
     * @return EntityPersister
     */
    private function getPersister(): EntityPersister
    {
        return $this->entityManager->getUnitOfWork()->getEntityPersister(User::class);
    }
}