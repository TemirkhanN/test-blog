<?php

declare(strict_types = 1);

namespace BlogBundle;

use BlogBundle\DependencyInjection\BlogExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Инициализатор модуля блога
 */
class BlogBundle extends Bundle
{
    /**
     * Создает расширение
     *
     * @return ExtensionInterface
     */
    public function createContainerExtension(): ExtensionInterface
    {
        return new BlogExtension();
    }
}
