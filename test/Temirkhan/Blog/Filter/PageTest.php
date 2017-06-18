<?php

namespace Temirkhan\Blog\Filter;

use PHPUnit\Framework\TestCase;
use Temirkhan\Blog\Filter\Exception\InvalidArgumentException;

class PageTest extends TestCase
{

    /**
     * Проверяем валидность аргумента "номер страницы"
     */
    public function testArgumentPageException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Page(-1, 1);
    }

    /**
     * Проверяем валидность аргумента "элементов на странице"
     */
    public function testCountArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        new Page(1, -1);
    }

    /**
     * Проверка метода получения номера страницы
     */
    public function testGetPage()
    {
        $page = new Page(5, 100);

        $this->assertEquals(5, $page->getPage());
    }

    /**
     * Проверка метода для получения количества записей
     */
    public function testGetCount()
    {
        $page = new Page(5, 100);

        $this->assertEquals(100, $page->getCount());
    }

    /**
     * Проверка сдига по элементам
     */
    public function testGetOffset()
    {
        $page = new Page(5, 100);

        $this->assertEquals(400, $page->getOffset());
    }


}