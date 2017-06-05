<?php
declare(strict_types = 1);

namespace BlogBundle\ParamConverter;

use BlogBundle\Entity\Author;
use BlogBundle\Service\AuthorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Конвертер текущего автора
 */
class CurrentAuthorParamConverter implements ParamConverterInterface
{
    /**
     * Хранилище ключей доступа
     *
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
     * Производит преобразование
     *
     * @param Request        $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $user   = $this->tokenStorage->getToken()->getUser();
        $author = null;

        if ($user) {
            $author = $this->authorService->getAuthorByUser($user);
        }

        $request->attributes->set($configuration->getName(), $author);
    }

    /**
     * Возвращает поддержку преобразования
     *
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        if ($configuration->getClass() !== Author::class) {
            return false;
        }

        if ($configuration->getName() !== 'currentAuthor') {
            return false;
        }

        return true;
    }
}