<?php

declare(strict_types=1);

namespace Temirkhan\Blog\Entity;

use DateTimeInterface;

/**
 * Интерфейс автора
 */
interface AuthorInterface
{
    /**
     * Возвращает идентификатор
     *
     * @return string|int
     */
    public function getId();

    /**
     * Возвращает имя
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Возвращает дату регистрации
     *
     * @return DateTimeInterface
     */
    public function getRegistrationDate(): DateTimeInterface;
}
