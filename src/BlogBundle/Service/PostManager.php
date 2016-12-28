<?php
declare(strict_types = 1);

namespace BlogBundle\Service;

use BlogBundle\Entity\Post;
use BlogBundle\Entity\User;
use BlogBundle\Repository\PostRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Routing\Router;

class PostManager
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var Router
     */
    private $router;

    /**
     * @param PostRepository $postRepository
     * @param UserManager    $userManager
     * @param Router         $router
     */
    public function __construct(
        PostRepository $postRepository,
        UserManager $userManager,
        Router $router
    )
    {
        $this->postRepository = $postRepository;
        $this->userManager    = $userManager;
        $this->router         = $router;
    }

    /**
     * @param Post $post
     * @param User $author
     *
     * @return Post
     */
    public function addPost(Post $post, User $author): Post
    {
        $post->setAuthor($author);
        $post->setAddDate(new \DateTime());

        $this->postRepository->savePost($post);

        return $post;
    }

    /**
     * Возвращает список опубликованных постов
     *
     * @param int $page
     * @param int $onPage
     *
     * @return Paginator
     */
    public function getPosts(int $page, int $onPage = 10): Paginator
    {
        return $this->getAllPosts($page, $onPage, Post::STATUS_PUBLISHED);
    }

    /**
     * @param User $author
     * @param int  $page
     * @param int  $onPage
     *
     * @return Paginator
     */
    public function getPostsByAuthor(User $author, int $page, int $onPage = 10): Paginator
    {
        return $this->getAllPosts($page, $onPage, null, $author);
    }

    /**
     * @param User $author
     * @param int  $page
     * @param int  $onPage
     *
     * @return Paginator
     */
    public function getPublishedPostsByAuthor(User $author, int $page, int $onPage = 10): Paginator
    {
        return $this->getAllPosts($page, $onPage, Post::STATUS_PUBLISHED, $author);
    }

    /**
     * @param Post $post
     *
     * @return string
     */
    public function getPostPageLink(Post $post): string
    {
        return $this->router->generate('blog_post', ['postId' => $post->getId()]);
    }

    /**
     * @return string
     */
    public function getPostsPageLink(): string
    {
        return $this->router->generate('blog_posts');
    }

    /**
     * @param int    $page
     * @param int    $onPage
     * @param string $status
     * @param User   $author
     *
     * @return Paginator
     */
    protected function getAllPosts(int $page, int $onPage = 10, string $status = null, User $author = null): Paginator
    {
        $onPage = $onPage > 1 ? $onPage : 10;
        $offset = ($page - 1) * $onPage;

        $criteria = new Criteria();
        $criteria
            ->setFirstResult($offset)
            ->setMaxResults($onPage)
            ->orderBy(['postRepository.pubDate' => Criteria::DESC]);

        if ($status) {
            $criteria->where(Criteria::expr()->eq('postRepository.status', $status));
            $conditionDefined = true;
        }

        if ($author) {
            $authorExpr = Criteria::expr()->eq('author', $author);
            !isset($conditionDefined) ? $criteria->where($authorExpr) : $criteria->andWhere($authorExpr);
        }

        return $this->postRepository->getPosts($criteria);
    }
}
