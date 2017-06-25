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
     * Сущьность пользователя
     *
     * @var User
     */
    private $user;

    /**
     * Установка окружения
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    /**
     * Очистка окружения
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->user = null;
    }

    /**
     * Проверка ID пользователя
     */
    public function testId(): void
    {
        $this->assertEquals(0, $this->user->getId());
    }
    /**
     * Проверка даты регистрации
     */
    public function testDateReg(): void
    {
        $date = new DateTime();
        $user = new User($date);

        $this->assertEquals($date, $user->getRegDate());
    }

    /**
     * Проверка логина
     */
    public function testLogin(): void
    {
        $login = 'some login';

        $this->assertEmpty($this->user->getLogin());

        $this->user->setLogin($login);

        $this->assertEquals($login, $this->user->getLogin());
    }

    /**
     * Проверка имени пользователя
     */
    public function testUserName(): void
    {
        $login = 'some login';

        $this->assertEmpty($this->user->getUsername());

        $this->user->setLogin($login);

        $this->assertEquals($login, $this->user->getUsername());
    }

    /**
     * Проверка пароля
     */
    public function testPassword(): void
    {
        $password = 'some pwd';

        $this->assertEmpty($this->user->getPassword());

        $this->user->setPassword($password);

        $this->assertEquals($password, $this->user->getPassword());
    }

    /**
     * Проверка ролей
     */
    public function testRoles(): void
    {
        $role = 'Some Role';

        $this->user->addRole($role);

        $this->assertContains($role, $this->user->getRoles());

        $this->user->addRole($role);

        $this->assertCount(count($this->user->getRoles()), array_unique($this->user->getRoles()));

        $this->user->removeRole($role);

        $this->assertNotContains($role, $this->user->getRoles());
    }

    /**
     * Проверка очистки учетных данных пользователя
     */
    public function testEraseCredentials(): void
    {
        $this->assertNull($this->user->eraseCredentials());
    }
}
