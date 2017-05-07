<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Service;

/**
 * Интерфейс выхода из системы
 */
interface LogoutServiceInterface
{
    /**
     * Выходит из системы
     */
    public function logout();
}