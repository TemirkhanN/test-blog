<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Filter;

/**
 * Постраничный фильтр
 */
class PageFilter
{
    /**
     * Текущая страница
     *
     * @var int
     */
    private $page;

    /**
     * Число элементов на страницу
     *
     * @var int
     */
    private $count;

    /**
     * Сдвиг по общему числу элементов на странице
     *
     * @var int
     */
    private $offset;

    public function __construct(int $page, int $count)
    {
        $this->page   = $page;
        $this->count  = $count;
        $this->offset = ($page-1) * $count;
    }

    /**
     * Возвращает текущую страницу
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Возвращает количество элементов на странице
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * Возвращает ожидаемый сдвиг по элементам
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}
