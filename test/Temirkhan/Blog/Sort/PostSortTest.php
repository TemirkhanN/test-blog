<?php
/**
 * Created by PhpStorm.
 * User: ser
 * Date: 23.06.17
 * Time: 1:46
 */

namespace Temirkhan\Blog\Sort;

use PHPUnit\Framework\TestCase;
use Temirkhan\Blog\Sort\Exception\InvalidArgumentException;

/**
 * Тесты класса сортировки постов
 */
class PostSortTest extends TestCase
{

    /**
     * Сортировки по дате по умолчанию
     */
    public function testSortIfDateNotExists(): void
    {
        $post = new PostSort([]);

        $this->assertEquals('desc', $post->getPubDate());
    }

    /**
     * Поведение при некорректном направлении сортировки
     */
    public function testBehaviorForInvalidDirection(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new PostSort([
            'add_date' => 'invalid sort'
        ]);
    }

    /**
     * Сортировка по дате публикации
     */
    public function testSortByPublicationDate(): void
    {
        $direction = 'asc';

        $post = new PostSort([
            'add_date' => $direction
        ]);

        $this->assertEquals($direction, $post->getPubDate());
    }
}
