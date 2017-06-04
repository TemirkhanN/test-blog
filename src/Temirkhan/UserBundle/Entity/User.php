<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Пользователь
 *
 * @ORM\Entity()
 * @ORM\Table(name="`user`", indexes={
 *     @ORM\Index(name="user_login_idx", columns={"login"})
 * })
 */
class User implements UserInterface, EncoderAwareInterface
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
     * Соль, использованная для создания пароля
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * Список ролей пользователя
     *
     * @var array
     *
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $roles = [];

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
     * Возвращает логин пользователя
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getLogin();
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

    /**
     * Возвращает соль
     *
     * @return null
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Возвращает список ролей
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Добавляет роль
     *
     * @param string $role
     */
    public function addRole(string $role)
    {
        if (in_array($role, $this->roles)) {
            return;
        }

        $this->roles[] = $role;
    }

    /**
     * Удаляет роль
     *
     * @param string $role
     */
    public function removeRole(string $role)
    {
        $roles = array_flip($this->roles);

        if (!array_key_exists($role, $roles)) {
            return;
        }

        unset($roles[$role]);

        $this->roles = array_keys($roles);
    }

    /**
     * Вычищает уязвимые данные
     */
    public function eraseCredentials()
    {
        return;
    }

    /**
     * Возвращает шифратор пароля
     *
     * @return string
     */
    public function getEncoderName()
    {
        return BCryptPasswordEncoder::class;
    }
}