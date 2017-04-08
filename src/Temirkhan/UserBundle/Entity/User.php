<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Пользователь
 *
 * @ORM\Entity()
 * @ORM\Table(name="user", indexes={
 *     @ORM\Index(name="user_login_idx", columns={"login"})
 * })
 */
class User
{
    /**
     * Идентификатор
     *
     * @var int
     *
     * @ORM\Id()
     *
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id = 0;

    /**
     * Логин
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $login = '';

    /**
     * Пароль
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $password = '';

    /**
     * Дата регистрации
     *
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $regDate;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->regDate = new DateTime();
    }

    /**
     * Возвращает идентификатор
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * Устанавливает логин
     *
     * @param string $login
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
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

    /**
     * Устанавливает пароль
     *
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Возвращает дату регистрации
     *
     * @return DateTime
     */
    public function getRegDate(): DateTime
    {
        return clone $this->regDate;
    }

    /**
     * Устанавливает дату регистрации
     *
     * @param DateTime $regDate
     */
    public function setRegDate(DateTime $regDate)
    {
        $this->regDate = clone $regDate;
    }
}