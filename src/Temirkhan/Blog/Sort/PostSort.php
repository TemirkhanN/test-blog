<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Sort;

/**
 * Сортировка публикаций
 */
class PostSort
{
    const SORT_ASC  = 'asc';
    const SORT_DESC = 'desc';

    /**
     * Сортировка по дате публикации
     *
     * @var string
     */
    private $pubDate = self::SORT_DESC;

    /**
     * Конструктор
     *
     * @param array $sort
     *
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(array $sort = [])
    {
        if (!isset($sort['add_date'])) {
            return;
        }

        $sortByAddDate = strtolower($sort['add_date']);

        if (!$this->supportsDirection($sortByAddDate)) {
            throw new Exception\InvalidArgumentException('Передан недопустимый аргумент');
        }

        $this->pubDate = $sortByAddDate;
    }

    /**
     * Возвращает направление сортировки по дате публикации
     *
     * @return string
     */
    public function getPubDate(): string
    {
        return $this->pubDate;
    }

    /**
     * Возвращает поддержку переданного направления сортировки
     *
     * @param string $direction
     *
     * @return bool
     */
    protected function supportsDirection(string $direction): bool
    {
        if (!in_array($direction, [self::SORT_DESC, self::SORT_ASC])) {
            return false;
        }

        return true;
    }
}
