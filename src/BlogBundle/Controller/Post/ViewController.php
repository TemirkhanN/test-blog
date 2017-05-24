<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Post;

use BlogBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
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
     *
     * @return Response
     *
     * @Configuration\ParamConverter("post")
     * @Configuration\Security("is_granted('view_post'))
     */
    public function execute(PostInterface $post): Response
    {
        return $this->respond('@Blog/post/common-item.html.twig', ['post' => $post]);
    }
}
