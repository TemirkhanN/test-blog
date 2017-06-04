<?php

declare(strict_types = 1);

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Абстрактный класс контроллера, оперирующего движком для рендеринга
 */
abstract class AbstractController
{
    /**
     * Движок
     *
     * @var EngineInterface
     */
    private $renderer;

    /**
     * Конструктор
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->renderer = $engine;
    }

    /**
     * Возвращает отрисованную страницу
     *
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
     * Создает перенаправление
     *
     * @param string $link
     *
     * @return RedirectResponse
     */
    protected function respondRedirect(string $link): RedirectResponse
    {
        return new RedirectResponse($link);
    }

    /**
     * Добавляет сообщение об ошибке во временную память
     *
     * @param string $error
     */
    protected function addFlashError(string $error)
    {
        (new Session())->getFlashBag()->add('error', $error);
    }
}
