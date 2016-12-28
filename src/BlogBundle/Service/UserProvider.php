<?php
declare(strict_types = 1);

namespace BlogBundle\Service;


use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider implements UserInterface
{
    public function getRoles()
    {
        return
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}