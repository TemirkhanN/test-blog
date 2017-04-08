<?php

declare(strict_types = 1);

namespace BlogBundle\Controller\Post;

use BlogBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер создания публикации
 */
class CreateController extends AbstractController
{
    /**
     * Создает публикацию
     *
     * @return Response
     */
    public function execute(Request $request): Response
    {
        return $this->respondRedirect('/');
    }
}
