<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Service;

use Symfony\Component\HttpFoundation\Response;

/**
 * Интерфейс сервиса входа в систему
 */
interface LoginServiceInterface
{
    /**
     * Производит вход в систему
     *
     * @param array $loginData
     *
     * @return Response
     */
    public function login(array $loginData): Response;
}