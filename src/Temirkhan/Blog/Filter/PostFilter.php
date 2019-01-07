<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Filter;

use Temirkhan\Blog\Entity\PostInterface;

/**
 * Фильтр публикаций
 */
class PostFilter
{
    /**
     * Автор
     *
     * @var int|null
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
        $this->status = PostInterface::STATUS_PUBLISHED;

        if (!isset($filter['author'])) {
            return;
        }
        $this->author = (int) $filter['author'];
    }

    /**
     * Устанавливает фильтр по автору
     *
     * @param int $id
     */
    public function setAuthor(int $id)
    {
        $this->author = $id;
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
    public function getStatus()
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
