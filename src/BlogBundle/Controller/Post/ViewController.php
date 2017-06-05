<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Post;

use BlogBundle\Controller\AbstractController;
use BlogBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\Blog\Entity\PostInterface;

/**
 * Контроллер просмотра публикации
 */
class ViewController extends AbstractController
{
    /**
     * Просмотр публикации
     *
     * @param PostInterface $post
     * @param Author        $currentAuthor
     *
     * @return Response
     *
     * @Extra\ParamConverter("post", class="BlogBundle:Post")
     * @Extra\ParamConverter("currentAuthor")
     */
    public function execute(PostInterface $post, Author $currentAuthor): Response
    {
        $isOwner = $post->isPublishedBy($currentAuthor);

        return $this->respond('@Blog/post/common-item.html.twig', ['post' => $post, 'isOwner' => $isOwner]);
    }
}
