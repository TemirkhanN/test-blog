<?php

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\OrderBy;
use BlogBundle\Repository\PostRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Post
 * @package BlogBundle\Entity
 *
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\PostRepository")
 * @ORM\Table(name="post", indexes={@Index(name="author_id_index", columns={"author_id"})})
 */
class Post
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(
     *     min=10,
     *     max=255,
     *     minMessage="Заголовок должен быть не короче 10 символов",
     *     maxMessage="Заголовок должен быть не длиннее 255 символов"
     * )
     */
    private $title;

    /**
     * @ORM\Column(name="teaser", type="string", length=255)
     * @Assert\Length(
     *     min=10,
     *     max=255,
     *     minMessage="Тизер должен быть не короче 10 символов",
     *     maxMessage="Тизер должен быть не длиннее 255 символов"
     * )
     * @Assert\NotBlank()
     */
    private $teaser;

    /**
     * @ORM\Column(type="text", length=3000)
     * @Assert\Length(
     *     min=10,
     *     max=3000,
     *     minMessage="Текст публикации должен быть не короче 10 символов",
     *     maxMessage="Текст публикации  должен быть не длиннее 3000 символов"
     * )
     */
    private $content;

    /**
     * @ORM\Column(name="`status`", type="integer", options={"default":1})
     * @Assert\Choice(
     *     choices  = {0, 1},
     *     message = "Недопустимый статус публикации"
     * )
     */
    private $status = self::STATUS_DRAFT;

    /**
     * @ORM\Column(name="add_date", type="datetime")
     */
    private $addDate;

    /**
     * @ORM\Column(name="pub_date", type="datetime", nullable=true)
     */
    private $pubDate;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     * @OrderBy({"pubDate"="DESC"})
     */
    private $comments;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = strip_tags($content);

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set addDate
     *
     * @param \DateTime $addDate
     *
     * @return Post
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Get addDate
     *
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * Set pubDate
     *
     * @param \DateTime $pubDate
     *
     * @return Post
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * Get pubDate
     *
     * @return \DateTime
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Set teaser
     *
     * @param string $teaser
     *
     * @return Post
     */
    public function setTeaser($teaser)
    {
        $this->teaser = strip_tags($teaser);

        return $this;
    }

    /**
     * Get teaser
     *
     * @return string
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Post
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set author
     *
     * @param \BlogBundle\Entity\User $author
     *
     * @return Post
     */
    public function setAuthor(\BlogBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \BlogBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add comment
     *
     * @param \BlogBundle\Entity\Comment $comment
     *
     * @return Post
     */
    public function addComment(\BlogBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
