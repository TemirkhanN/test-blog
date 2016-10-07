<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Comment
 *
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\CommentRepository")
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
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;


    /**
     * @ORM\Column(name="content", type="text", length=3000)
     * @Assert\Length(
     *     min=5,
     *     max=3000,
     *     minMessage="Текст комментария не может быть короче 5 символов",
     *     maxMessage="Текст комментария не может быть длиннее 3000 символов"
     * )
     */
    private $content;

    /**
     * @ORM\Column(name="pub_date", type="datetime")
     */
    private $pubDate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

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
     * Set post
     *
     * @param \BlogBundle\Entity\Post $post
     *
     * @return Comment
     */
    public function setPost(\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set author
     *
     * @param \BlogBundle\Entity\User $author
     *
     * @return Comment
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
     * Set pubDate
     *
     * @param \DateTime $pubDate
     *
     * @return Comment
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
}
