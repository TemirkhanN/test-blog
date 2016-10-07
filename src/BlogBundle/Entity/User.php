<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package BlogBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\Length(min=3, max=50)
     *
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(
     *     min=6,
     *     minMessage="Пароль не может быть короче 6 символов"
     * )
     */
    private $password;


    /**
     * @ORM\Column(type="string", name="`name`", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(name="reg_date", type="datetime")
     */
    private $regDate;

    /**
     * @ORM\Column(name="last_signed", type="datetime", nullable=true)
     */
    private $lastSigned;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set regDate
     *
     * @param \DateTime $regDate
     *
     * @return User
     */
    public function setRegDate($regDate)
    {
        $this->regDate = $regDate;

        return $this;
    }

    /**
     * Get regDate
     *
     * @return \DateTime
     */
    public function getRegDate()
    {
        return $this->regDate;
    }

    /**
     * Set lastSigned
     *
     * @param \DateTime $lastSigned
     *
     * @return User
     */
    public function setLastSigned($lastSigned)
    {
        $this->lastSigned = $lastSigned;

        return $this;
    }

    /**
     * Get lastSigned
     *
     * @return \DateTime
     */
    public function getLastSigned()
    {
        return $this->lastSigned;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
