<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Filter;

use PHPUnit\Framework\TestCase;

/**
 * Тест фильтра публикаций
 */
class PostFilterTest extends TestCase
{
    /**
     * Проверка фильтра при отсутствии автора
     */
    public function testFilterIfAuthorNotExists(): void
    {
        $post = new PostFilter([]);

        $this->assertEquals(null, $post->getAuthor());
    }

    /**
     * Проверка фильтра по автору
     */
    public function testFilterAuthor(): void
    {
        $author = 1;

        $post = new PostFilter([
            'author' => $author
        ]);

        $this->assertEquals($author, $post->getAuthor());
    }

    /**
     * Проверка установки фильтра по автору
     */
    public function testSetAuthor(): void
    {
        $author = 1;

        $post = new PostFilter([]);

        $this->assertEquals(null, $post->getAuthor());

        $post->setAuthor($author);

        $this->assertEquals($author, $post->getAuthor());
    }

    /**
     * Проверка фильтра по статусу
     */
    public function testFilterStatus(): void
    {
        $status = 'some status';

        $post = new PostFilter([]);

        $this->assertEquals(null, $post->getStatus());

        $post->setStatus($status);

        $this->assertEquals($status, $post->getStatus());
    }
}
