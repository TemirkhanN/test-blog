<?php

namespace BlogBundle\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\OrderBy;
use Temirkhan\Blog\Entity\AuthorInterface;
use Temirkhan\Blog\Entity\CommentInterface;
use Temirkhan\Blog\Entity\PostInterface;

/**
 * Публикация
 *
 * @ORM\Entity()
 * @ORM\Table(name="post", indexes={@Index(name="author_id_index", columns={"author_id"})})
 */
class Post implements PostInterface
{
    /**
     * Идентификатор
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id = 0;

    /**
     * Автор
     *
     * @var AuthorInterface
     *
     * @ManyToOne(targetEntity="Author")
     * @JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * Заголовок
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title = '';

    /**
     * Краткая аннотация
     *
     * @var string
     *
     * @ORM\Column(name="teaser", type="string", length=255)
     */
    private $teaser = '';

    /**
     * Текст публикации
     *
     * @var string
     *
     * @ORM\Column(type="text", length=3000)
     */
    private $content = '';

    /**
     * Статус
     *
     * @var string
     *
     * @ORM\Column(name="`status`", type="string", length=10)
     */
    private $status = self::STATUS_DRAFT;

    /**
     * Дата добавления
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(name="add_date", type="datetime")
     */
    private $addDate;

    /**
     * Дата опубликования
     *
     * @var DateTimeInterface|null
     *
     * @ORM\Column(name="pub_date", type="datetime", nullable=true)
     */
    private $pubDate;

    /**
     * Комментарии
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     * @OrderBy({"addDate"="DESC"})
     */
    private $comments;

    /**
     * Конструктор
     *
     * @param AuthorInterface $author
     */
    public function __construct(AuthorInterface $author)
    {
        $this->addDate  = new DateTime();
        $this->author   = $author;
        $this->comments = new ArrayCollection();
    }

    /**
     * Возвращает идентификатор
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * Устанавливает заголовок
     *
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Возвращает заголовок
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Устанавливает контект
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Возвращает контект
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Указывает дату создания
     *
     * @param DateTimeInterface $addDate
     */
    public function setAddDate(DateTimeInterface $addDate)
    {
        $this->addDate = $addDate;
    }

    /**
     * Возвращает дату создания
     *
     * @return DateTimeInterface
     */
    public function getAddDate(): DateTimeInterface
    {
        return $this->addDate;
    }

    /**
     * Устанавливает дату опубликования
     *
     * @param DateTimeInterface $pubDate
     */
    public function setPubDate(DateTimeInterface $pubDate)
    {
        $this->pubDate = $pubDate;
    }

    /**
     * Возвращает дату опубликования
     *
     * @return null|DateTimeInterface
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Устанавливает аннотацию
     *
     * @param string $teaser
     */
    public function setTeaser(string $teaser)
    {
        $this->teaser = $teaser;
    }

    /**
     * Возвращает аннотацию
     *
     * @return string
     */
    public function getTeaser(): string
    {
        return $this->teaser;
    }

    /**
     * Устанавливает статус
     *
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * Возвращает, в черновиках ли пост
     *
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Возвращает, опубликован ли пост
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    /**
     * Возвращает автора
     *
     * @return AuthorInterface
     */
    public function getAuthor(): AuthorInterface
    {
        return $this->author;
    }

    /**
     * Добавляет комментарий
     *
     * @param CommentInterface $comment
     */
    public function addComment(CommentInterface $comment)
    {
        $this->comments->add($comment);
    }

    /**
     * Удаляет комментарий
     *
     * @param CommentInterface $comment
     */
    public function deleteComment(CommentInterface $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Возвращает комментарии
     *
     * @return CommentInterface[]
     */
    public function getComments(): array
    {
        return $this->comments->toArray();
    }

    /**
     * Проверяет, принадлежит ли публикация переданному автору
     *
     * @param AuthorInterface $author
     *
     * @return bool
     */
    public function isPublishedBy(AuthorInterface $author): bool
    {
        if ($this->author->getId() === $author->getId()) {
            return true;
        }

        return false;
    }
}
