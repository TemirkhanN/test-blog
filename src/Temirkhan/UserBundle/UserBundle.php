<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Temirkhan\UserBundle\DependencyInjection\UserExtension;

/**
 * Модуль пользователей
 */
class UserBundle extends Bundle
{
    /**
     * Создает расширение
     *
     * @return ExtensionInterface
     */
    public function createContainerExtension(): ExtensionInterface
    {
        return new UserExtension();
    }
}
