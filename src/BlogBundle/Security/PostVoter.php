<?php
declare(strict_types = 1);

namespace BlogBundle\Security;

use BlogBundle\Entity\Article;
use Doctrine\Common\Util\Debug;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PostVoter extends Voter
{
    const READ   = 'view';
    const WRITE  = 'edit';
    const DELETE = 'delete';

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        $actions = [
            self::READ,
            self::WRITE,
            self::DELETE,
        ];

        if (!in_array($attribute, $actions)) {
            return false;
        }

        if (!$subject instanceof Article) {
            return false;
        }
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if(!$user){
            return false;
        }

        switch($attribute) {
            case self::READ:
                return $subject->getAuthor->getId() === $user->getId();
        }

        return false;
    }
}