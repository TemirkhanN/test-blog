<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\ValueObject;

use PHPUnit\Framework\TestCase;

/**
 * Тест регистрационных данных
 */
class RegistrationCredentialsTest extends TestCase
{
    /**
     * Проверка логина
     */
    public function testLogin(): void
    {
        $login = 'some login';

        $credentials = new RegistrationCredentials($login, 'some pwd');

        $this->assertEquals($login, $credentials->getLogin());
    }


    /**
     * Проверка пароля
     */
    public function testPassword(): void
    {
        $password = 'some pwd';

        $credentials = new RegistrationCredentials('some login', $password);

        $this->assertEquals($password, $credentials->getPassword());
    }
}
