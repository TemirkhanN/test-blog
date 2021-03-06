<?php

declare(strict_types=1);

namespace BlogBundle\Service;

use BlogBundle\Entity\Author;
use BlogBundle\ValueObject\RegistrationCredentials;
use BlogBundle\Repository\AuthorRepository;
use Temirkhan\Blog\Entity\AuthorInterface;
use Temirkhan\UserBundle\Entity\User;
use Temirkhan\UserBundle\Service\UserService;

/**
 * Сервис авторов
 */
class AuthorService
{
    /**
     * Сервис пользователей
     *
     * @var UserService
     */
    private $userService;

    /**
     * Репозиторий авторов
     *
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * Конструктор
     *
     * @param UserService      $userService
     * @param AuthorRepository $authorRepository
     */
    public function __construct(UserService $userService, AuthorRepository $authorRepository)
    {
        $this->userService      = $userService;
        $this->authorRepository = $authorRepository;
    }

    /**
     * Регистрирует автора в системе
     *
     * @param RegistrationCredentials $registrationCredentials
     *
     * @return Author
     */
    public function registerAuthor(RegistrationCredentials $registrationCredentials): Author
    {
        $user = $this->userService->registerUser($registrationCredentials);

        $author = new Author($user);
        $author->setName($registrationCredentials->getName());

        $this->authorRepository->add($author);

        return $author;
    }

    /**
     * Возвращает автора по пользователю
     *
     * @param User $user
     *
     * @return AuthorInterface|null
     */
    public function getAuthorByUser(User $user)
    {
        return $this->authorRepository->findOneBy(['user' => $user]);
    }
}
