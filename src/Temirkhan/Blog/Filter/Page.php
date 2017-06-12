<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Filter;

/**
 * Страница
 */
class Page
{
    /**
     * Номер страницы
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

    /**
     * Конструктор
     *
     * @param int $page
     * @param int $count
     *
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(int $page, int $count)
    {
        if ($page < 1) {
            throw new Exception\InvalidArgumentException('Некорректный номер страницы');
        }

        if ($count < 1) {
            throw new Exception\InvalidArgumentException('Некорректное число элементов на страницу');
        }

        $this->page   = $page;
        $this->count  = $count;
        $this->offset = ($page - 1) * $count;
    }

    /**
     * Возвращает номер страницы
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
