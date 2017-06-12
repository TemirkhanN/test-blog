<?php

declare(strict_types = 1);

namespace BlogBundle\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Temirkhan\Blog\Entity\AuthorInterface;
use Temirkhan\UserBundle\Entity\User;

/**
 * Автор
 *
 * @ORM\Entity
 */
class Author implements AuthorInterface
{
    const ROLE_AUTHOR = 'ROLE_AUTHOR';

    /**
     * Идентификатор
     *
     * @var int
     *
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $id = 0;

    /**
     * Имя
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Пользователь
     *
     * @var User
     *
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\OneToOne(targetEntity="Temirkhan\UserBundle\Entity\User", orphanRemoval=true)
     */
    private $user;

    /**
     * Конструктор
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->user->addRole(self::ROLE_AUTHOR);
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
     * Возвращает пользователя
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
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

    /**
     * Устанавливает имя
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Возвращает дату регистрации
     *
     * @return DateTimeInterface
     */
    public function getRegistrationDate(): DateTimeInterface
    {
        return $this->getUser()->getRegDate();
    }
}
