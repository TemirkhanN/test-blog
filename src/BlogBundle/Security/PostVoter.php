<?php

declare(strict_types = 1);

namespace BlogBundle\Security;

use BlogBundle\Entity\Post;
use BlogBundle\Service\AuthorService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Определитель возможности действия над публикацией
 */
class PostVoter extends Voter
{
    const VIEW   = 'view';
    const EDIT   = 'edit';
    const DELETE = 'delete';

    /**
     * Сервис авторов
     *
     * @var AuthorService
     */
    private $authorService;

    /**
     * Конструктор
     *
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Возвращает поддержку операции над субъектом
     *
     * @param string $attribute
     * @param mixed  $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Post) {
            return false;
        }

        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        return true;
    }

    /**
     * Возвращает возможность совершения действия над публикацией
     *
     * @param string         $attribute
     * @param Post           $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user) {
            return false;
        }

        $author = $this->authorService->getAuthorByUser($user);

        switch ($attribute) {
            case self::VIEW:
                if ($subject->isPublished()) {
                    return true;
                }

                if ($subject->isPublishedBy($author)) {
                    return true;
                }

                return false;
            case self::DELETE:
            case self::EDIT:
                return $subject->isPublishedBy($author);
            default:
                return false;
        }
    }
}
