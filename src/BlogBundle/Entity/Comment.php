<?php

namespace BlogBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * Комментарий
 *
 * @ORM\Table(name="comment",
 *      indexes={
 *          @Index(name="pubdate_index", columns={"pub_date"}),
 *          @Index(name="target_index", columns={"author_id", "post_id"})
 *      }
 * )
 */
class Comment
{
    /**
     * Идентификатор
     *
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id = 0;

    /**
     * Комментируемая публикация
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * Автор
     *
     * @ORM\ManyToOne(targetEntity="Author")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;


    /**
     * Текст комментария
     *
     * @ORM\Column(name="content", type="text", length=3000)
     */
    private $content;

    /**
     * Дата добавления комментария
     *
     * @ORM\Column(name="add_date", type="datetime")
     */
    private $addDate;

    /**
     * Конструктор
     *
     * @param Author $author
     * @param Post   $article
     */
    public function __construct(Author $author, Post $article)
    {
        $this->post    = $article;
        $this->author  = $author;
        $this->addDate = new DateTime();
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
     * Устанавливает текст комментария
     *
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * Возвращает текст комментария
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Возвращает комментируемый элемент
     *
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Возвращает автора
     *
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }

    /**
     * Устанавливает дату добавления
     *
     * @param DateTime $addDate
     *
     * @return Comment
     */
    public function setAddDate(DateTime $addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Возвращает дату добавления
     *
     * @return DateTime
     */
    public function getAddDate(): DateTime
    {
        return $this->addDate;
    }
}
