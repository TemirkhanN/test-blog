<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Entity;

use DateTimeInterface;

/**
 * Интерфейс публикации
 */
interface PostInterface
{
    const STATUS_DRAFT     = 'draft';
    const STATUS_PUBLISHED = 'published';

    /**
     * Возвращает идентификатор
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Возвращает заголовок
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Возвращает контект
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Возвращает дату создания
     *
     * @return DateTimeInterface
     */
    public function getAddDate(): DateTimeInterface;

    /**
     * Возвращает дату опубликования
     *
     * @return null|DateTimeInterface
     */
    public function getPubDate();

    /**
     * Возвращает аннотацию
     *
     * @return string
     */
    public function getTeaser(): string;

    /**
     * Возвращает, находится ли публикация в общем доступе
     *
     * @return bool
     */
    public function isPublished(): bool;

    /**
     * Возвращает, находится ли публикация в черновике
     *
     * @return bool
     */
    public function isDraft(): bool;

    /**
     * Возвращает автора
     *
     * @return AuthorInterface
     */
    public function getAuthor(): AuthorInterface;

    /**
     * Добавляет комментарий
     *
     * @param CommentInterface $comment
     */
    public function addComment(CommentInterface $comment);

    /**
     * Удаляет комментарий
     *
     * @param CommentInterface $comment
     */
    public function deleteComment(CommentInterface $comment);

    /**
     * Возвращает комментарии
     *
     * @return CommentInterface[]
     */
    public function getComments(): array;

    /**
     * Определяет, принадлежит ли публикация переданному автору
     *
     * @param AuthorInterface $author
     *
     * @return bool
     */
    public function isPublishedBy(AuthorInterface $author): bool;
}
