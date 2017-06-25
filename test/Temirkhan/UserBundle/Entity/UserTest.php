<?php

declare(strict_types=1);

namespace Temirkhan\UserBundle\Entity;

use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Тест пользователя
 */
class UserTest extends TestCase
{
    /**
     * Проверка даты регистрации
     */
    public function testDateReg(): void
    {
        $date = new DateTime('2017-06-25 12:38:27');

        $user = new User();

        $this->assertEquals(
            (new DateTime())->format('Y-m-d'),
            $user->getRegDate()->format('Y-m-d')
        );

        $user->setRegDate($date);

        $this->assertEquals($date, $user->getRegDate());
    }

    /**
     * Проверка логина
     */
    public function testLogin(): void
    {
        $login = 'some login';
        $user  = new User();

        $this->assertEmpty($user->getLogin());

        $user->setLogin($login);

        $this->assertEquals($login, $user->getLogin());
    }

    /**
     * Проверка имени пользователя
     */
    public function testUserName(): void
    {
        $login = 'some login';
        $user  = new User();

        $this->assertEmpty($user->getUsername());

        $user->setLogin($login);

        $this->assertEquals($login, $user->getUsername());
    }

    /**
     * Проверка пароля
     */
    public function testPassword(): void
    {
        $password = 'some pwd';
        $user     = new User();

        $this->assertEmpty($user->getPassword());

        $user->setPassword($password);

        $this->assertEquals($password, $user->getPassword());
    }

    /**
     * Проверка ролей
     */
    public function testRoles(): void
    {
        $role = 'Some Role';
        $user = new User();

        $this->assertEquals([], $user->getRoles());

        $user->addRole($role);

        $this->assertEquals([ $role ], $user->getRoles());

        $user->removeRole($role);

        $this->assertEquals([], $user->getRoles());
    }
}
