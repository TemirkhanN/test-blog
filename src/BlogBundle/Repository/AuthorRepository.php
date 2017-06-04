<?php

declare(strict_types=1);

namespace BlogBundle\Repository;

use BlogBundle\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Репозиторий авторов
 */
class AuthorRepository
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
     * @param Author $author
     */
    public function add(Author $author)
    {
        $this->entityManager->persist($author);
    }
}