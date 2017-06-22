<?php

namespace Temirkhan\Blog\Filter;

use PHPUnit\Framework\TestCase;
use Temirkhan\Blog\Filter\Exception\InvalidArgumentException;

/**
 * Тесты фильтра страницы
 */
class PageTest extends TestCase
{
    /**
     * Поведение при не корректном номере страницы
     */
    public function testInvalidPage() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Page(-1, 1);
    }

    /**
     * Поведение при не корректном количестве записей на страницу
     */
    public function testInvalidCount() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Page(1, -1);
    }

    /**
     * Получение номера страницы
     */
    public function testPage() : void
    {
        $page = new Page(3, 6);

        $this->assertEquals(3, $page->getPage());
    }

    /**
     * Получение количества записей
     */
    public function testCount() : void
    {
        $page = new Page(3, 6);

        $this->assertEquals(6, $page->getCount());
    }

    /**
     * Получение сдвига по элементам
     */
    public function testOffset() : void
    {
        $page = new Page(3, 6);

        $this->assertEquals(12, $page->getOffset());
    }
}
