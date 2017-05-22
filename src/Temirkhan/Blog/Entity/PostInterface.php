<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Entity;

use DateTimeInterface;

/**
 * Интерфейс публикации
 */
interface PostInterface
{
    /**
     * Устанавливает заголовок
     *
     * @param string $title
     */
    public function setTitle(string $title);

    /**
     * Возвращает заголовок
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Устанавливает контект
     *
     * @param string $content
     */
    public function setContent($content);

    /**
     * Возвращает контект
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Указывает дату создания
     *
     * @param DateTimeInterface $addDate
     */
    public function setAddDate(DateTimeInterface $addDate);

    /**
     * Возвращает дату создания
     *
     * @return DateTimeInterface
     */
    public function getAddDate(): DateTimeInterface;

    /**
     * Устанавливает дату опубликования
     *
     * @param DateTimeInterface $pubDate
     */
    public function setPubDate(DateTimeInterface $pubDate);

    /**
     * Возвращает дату опубликования
     *
     * @return null|DateTimeInterface
     */
    public function getPubDate();

    /**
     * Устанавливает аннотацию
     *
     * @param string $teaser
     */
    public function setTeaser(string $teaser);

    /**
     * Возвращает аннотацию
     *
     * @return string
     */
    public function getTeaser(): string;

    /**
     * Устанавливает статус
     *
     * @param string $status
     */
    public function setStatus(string $status);

    /**
     * Возвращает статус
     *
     * @return string
     */
    public function getStatus(): string;

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
}