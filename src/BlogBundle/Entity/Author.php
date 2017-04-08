<?php

declare(strict_types = 1);

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Temirkhan\UserBundle\Entity\User;

/**
 * Автор
 *
 * @ORM\Entity
 */
class Author
{
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
     * Пользователь
     *
     * @var User
     *
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\OneToOne(targetEntity="Temirkhan\UserBundle\Entity\User")
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
}