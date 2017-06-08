<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Filter;

/**
 * Фильтр публикаций
 */
class PostFilter
{
    /**
     * Автор
     *
     * @var string|null
     */
    private $author;

    /**
     * Статус
     *
     * @var string|null
     */
    private $status;

    /**
     * Конструктор
     *
     * @param array $filter
     */
    public function __construct(array $filter)
    {
        if (!isset($filter['author'])) {
            return;
        }

        $this->author = (string) $filter['author'];
    }

    /**
     * Устанавливает фильтр по автору
     *
     * @param int $id
     */
    public function setAuthor(int $id)
    {
        $this->author = (string) $id;
    }
    /**
     * Возвращает автора
     *
     * @return null|string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Возвращает статус
     *
     * @return null|string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Устанавливает статус
     *
     * @param null|string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
