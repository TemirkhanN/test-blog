<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Service;

use Temirkhan\UserBundle\ValueObject\LoginData;

/**
 * Интерфейс сервиса входа в систему
 */
interface LoginServiceInterface
{
    /**
     * Производит вход в систему
     *
     * @param LoginData $loginData
     *
     * @return bool
     */
    public function login(LoginData $loginData): bool;
}