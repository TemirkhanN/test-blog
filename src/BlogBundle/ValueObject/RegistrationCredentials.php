<?php

declare(strict_types=1);

namespace BlogBundle\ValueObject;

use Temirkhan\UserBundle\ValueObject\RegistrationCredentials as UserRegistrationCredentials;

/**
 * Данные для регистрации автора
 */
class RegistrationCredentials extends UserRegistrationCredentials
{
    /**
     * Имя
     *
     * @var string
     */
    private $name = '';

    /**
     * Конструктор
     *
     * @param string $name
     * @param string $login
     * @param string $password
     */
    public function __construct(string $name, string $login, string $password)
    {
        parent::__construct($login, $password);

        $this->name = $name;
    }

    /**
     * Возвращает имя
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}