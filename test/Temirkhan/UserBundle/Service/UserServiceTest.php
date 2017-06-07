<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Service;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Temirkhan\UserBundle\Entity\User;
use Temirkhan\UserBundle\Repository\UserRepository;
use Temirkhan\UserBundle\ValueObject\RegistrationCredentials;

/**
 * Тесты сервиса пользователей
 */
class UserServiceTest extends TestCase
{
    /**
     * Репозиторий пользователей
     *
     * @var MockObject|UserRepository
     */
    private $userRepository;

    /**
     * Фабрика шифраторов
     *
     * @var MockObject|EncoderFactoryInterface
     */
    private $passwordEncoder;

    /**
     * Сервис пользователей
     *
     * @var UserService
     */
    private $userService;

    /**
     * Установка окружения
     */
    protected function setUp()
    {
        parent::setUp();

        $this->userRepository  = $this->createMock(UserRepository::class);
        $this->passwordEncoder = $this->createMock(EncoderFactoryInterface::class);
        $this->userService     = new UserService($this->userRepository, $this->passwordEncoder);
    }

    /**
     * Очистка окружения
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->userRepository  = null;
        $this->passwordEncoder = null;
        $this->userService     = null;
    }

    /**
     * Проверяет регистрацию пользователя
     */
    public function testRegisterUser()
    {
        $expectedUser = null;
        $credentials  = $this->createRegistrationCredentials();

        $this->passwordEncoder
            ->expects($this->once())
            ->method('getEncoder')
            ->with($this->callback(function (User $user) use (&$expectedUser): bool {
                $expectedUser = $user;

                return true;
            }))
            ->willReturn($encoder = $this->createMock(PasswordEncoderInterface::class));

        $credentials
            ->expects($this->once())
            ->method('getPassword')
            ->willReturn('some password');

        $encoder
            ->expects($this->once())
            ->method('encodePassword')
            ->with($this->equalTo('some password'), $this->equalTo(null))
            ->willReturn('some encoded password');

        $this->userRepository
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(function (User $user) use (&$expectedUser): bool {
                $this->assertSame($expectedUser, $user);

                return true;
            }));

        $registeredUser = $this->userService->registerUser($credentials);

        $this->assertSame($expectedUser, $registeredUser);
    }

    /**
     * Создает набор данных для регистрации пользователя
     *
     * @return MockObject|RegistrationCredentials
     */
    private function createRegistrationCredentials(): RegistrationCredentials
    {
        return $this->createMock(RegistrationCredentials::class);
    }
}
