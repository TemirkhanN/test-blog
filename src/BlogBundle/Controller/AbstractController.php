<?php
declare(strict_types = 1);

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    /**
     * @var EngineInterface
     */
    private $renderer;

    /**
     * @param EngineInterface $engine
     */
    protected function setRenderer(EngineInterface $engine)
    {
        $this->renderer = $engine;
    }

    /**
     * @param string $template
     * @param array  $args
     *
     * @return Response
     */
    protected function respond(string $template, array $args = []): Response
    {
        return new Response($this->renderer->render($template, $args));
    }

    /**
     * Страница с сообщением о 404 ошибке
     *
     * @param string $message
     *
     * @return Response
     */
    protected function respondNotFound(string $message = 'Not found'): Response
    {
        return new Response(
            $this->renderer->render(
                '@Blog/technical/error404.html.twig',
                [
                    'message' => $message,
                ]
            ),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Страница с сообщением о ошибке доступа
     *
     * @param string $message
     *
     * @return Response
     */
    protected function respondAccessForbidden(string $message = 'Forbidden'): Response
    {
        return new Response(
            $this->renderer->render(
                '@Blog/technical/error403.html.twig',
                [
                    'message' => $message,
                ]
            ),
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * @param string $link
     *
     * @return RedirectResponse
     */
    protected function respondRedirect(string $link): RedirectResponse
    {
        return new RedirectResponse($link);
    }
}