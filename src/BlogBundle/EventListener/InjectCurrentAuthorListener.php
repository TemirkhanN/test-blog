<?php

declare(strict_types = 1);

namespace BlogBundle\EventListener;

use BlogBundle\Service\AuthorService;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Temirkhan\UserBundle\Entity\User;

/**
 * Инъектор текущего автора в параметры запроса
 */
class InjectCurrentAuthorListener
{
    /**
     * Хранилище ключей доступа

     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * Сервис авторов
     *
     * @var AuthorService
     */
    private $authorService;

    /**
     * Конструктор
     *
     * @param TokenStorageInterface $tokenStorage
     * @param AuthorService         $authorService
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthorService $authorService)
    {
        $this->tokenStorage  = $tokenStorage;
        $this->authorService = $authorService;
    }

    /**
     * Внедряет в аттрибуты запроса сущность текущего автора
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if (!$token = $this->tokenStorage->getToken()) {
            return;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return;
        }

        $author = $this->authorService->getAuthorByUser($user);

        $event->getRequest()->attributes->set('currentAuthor', $author);
    }
}
