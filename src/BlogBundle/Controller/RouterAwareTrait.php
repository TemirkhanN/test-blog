<?php

declare(strict_types=1);

namespace BlogBundle\Controller;

use Symfony\Component\Routing\RouterInterface;

/**
 * Трейт классов, работающих с роутером
 */
trait RouterAwareTrait
{
    /**
     * Роутер
     *
     * @var RouterInterface
     */
    private $router;

    /**
     * Устанавливает роутер
     *
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }
}