<?php
declare(strict_types = 1);

namespace Temirkhan\Blog\Repository;

use Temirkhan\Blog\Entity\AuthorInterface;

/**
 * Интерфейс репозитория авторов
 */
interface AuthorRepositoryInterface
{
    /**
     * Добавляет автора
     *
     * @param AuthorInterface $author
     */
    public function add(AuthorInterface $author);

    /**
     * Возвращает автора, удовлетворяющего условиям
     *
     * @param array $criteria
     *
     * @return AuthorInterface|null
     */
    public function findOneBy(array $criteria);
}