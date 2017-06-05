<?php

declare(strict_types=1);

namespace BlogBundle\Repository;

use BlogBundle\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Temirkhan\Blog\Entity\AuthorInterface;
use Temirkhan\Blog\Repository\AuthorRepositoryInterface;

/**
 * Репозиторий авторов
 */
class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * Менеджейр сущностей
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
     * Добавляет автора
     *
     * @param AuthorInterface $author
     */
    public function add(AuthorInterface $author)
    {
        $this->entityManager->persist($author);
    }

    /**
     * Возвращает автора, удовлетворяющего критериям
     *
     * @param array $criteria
     *
     * @return AuthorInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->entityManager->getRepository(Author::class)->findOneBy($criteria);
    }
}