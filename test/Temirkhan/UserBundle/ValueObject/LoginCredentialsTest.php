<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\ValueObject;

use PHPUnit\Framework\TestCase;

/**
 * Тест учетных данных для входа
 */
class LoginCredentialsTest extends TestCase
{
    /**
     * Проверка логина
     */
    public function testLogin(): void
    {
        $login = 'some login';

        $credentials = new LoginCredentials($login, 'some pwd');

        $this->assertEquals($login, $credentials->getLogin());
    }

    /**
     * Проверка пароля
     */
    public function testPassword(): void
    {
        $password = 'some pwd';

        $credentials = new LoginCredentials('some login', $password);

        $this->assertEquals($password, $credentials->getPassword());
    }
}
