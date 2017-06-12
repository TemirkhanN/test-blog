<?php

declare(strict_types = 1);

namespace BlogBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Temirkhan\Blog\Filter\Exception\InvalidArgumentException;
use Temirkhan\Blog\Filter\Page;

/**
 * Инъектор параметров текущей страницы в атрибуты запроса
 */
class InjectCurrentPageListener
{
    /**
     * Количество элементов на странице по-умолчанию
     *
     * @var int
     */
    private $defaultCount;

    /**
     * Конструктор
     *
     * @param int $defaultCount
     */
    public function __construct(int $defaultCount)
    {
        $this->defaultCount = $defaultCount;
    }

    /**
     * Инъектит текущую страницу в параметры запроса
     *
     * @param GetResponseEvent $event
     *
     * @throws BadRequestHttpException
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$page = $request->attributes->get('page')) {
            $page = $request->query->get('page');
        }

        if (!$page) {
            $page = 1;
        }

        if (!$count = $request->query->get('count')) {
            $count = $this->defaultCount;
        }

        try {
            $page = new Page((int) $page, (int) $count);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException('Некорректные параметры страницы');
        }

        $request->attributes->set('page', $page);
    }
}
