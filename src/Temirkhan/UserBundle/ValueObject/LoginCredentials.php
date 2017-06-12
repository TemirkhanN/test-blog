<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\ValueObject;

/**
 * Данные для входа в систему
 */
class LoginCredentials
{
    /**
     * Логин
     *
     * @var string
     */
    private $login;

    /**
     * Пароль
     *
     * @var string
     */
    private $password;

    /**
     * Конструктор
     *
     * @param string $login
     * @param string $password
     */
    public function __construct(string $login, string $password)
    {
        $this->login    = $login;
        $this->password = $password;
    }

    /**
     * Возвращает логин
     *
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Возвращает пароль
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
