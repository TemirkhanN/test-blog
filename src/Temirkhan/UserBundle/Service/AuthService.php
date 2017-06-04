<?php

declare(strict_types=1);

namespace Temirkhan\UserBundle\Service;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Temirkhan\UserBundle\ValueObject\LoginCredentials;

/**
 * Сервис аутентификации
 */
class AuthService
{
    /**
     * Ключ провайдера аутентификации
     *
     * @var string
     */
    private $providerKey;

    /**
     * Провайдер аутентификации
     *
     * @var AuthenticationProviderInterface
     */
    private $authenticator;

    /**
     * Хранилище ключей-доступа
     *
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * Конструктор
     *
     * @param AuthenticationProviderInterface $authenticationProvider
     * @param string $providerKey
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(AuthenticationProviderInterface $authenticationProvider, string $providerKey, TokenStorageInterface $tokenStorage)
    {
        $this->authenticator = $authenticationProvider;
        $this->providerKey   = $providerKey;
        $this->tokenStorage  = $tokenStorage;
    }

    /**
     * Производит аутентификацию на основе данных
     *
     * @param LoginCredentials $loginData
     */
    public function authenticate(LoginCredentials $loginData)
    {
        $unauthenticatedToken = new UsernamePasswordToken(
            $loginData->getLogin(),
            $loginData->getPassword(),
            $this->providerKey
        );

        $token = $this->authenticator->authenticate($unauthenticatedToken);

        $this->tokenStorage->setToken($token);
    }
}