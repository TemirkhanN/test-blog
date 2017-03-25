<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Controller;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Temirkhan\UserBundle\Form\LoginType;
use Temirkhan\UserBundle\Service\LoginServiceInterface;

/**
 * Тесты контроллера аутентификации
 */
class LoginControllerTest extends TestCase
{
    /**
     * Сервис входа в систему
     *
     * @var MockObject|LoginServiceInterface
     */
    private $loginService;

    /**
     * Фабрика форм
     *
     * @var MockObject|FormFactory
     */
    private $formFactory;

    /**
     * Контроллер аутентификации
     *
     * @var LoginController
     */
    private $controller;

    /**
     * Установка окружения
     */
    protected function setUp()
    {
        parent::setUp();

        $this->formFactory  = $this->createMock(FormFactory::class);
        $this->loginService = $this->createMock(LoginServiceInterface::class);
        $this->controller   = new LoginController($this->loginService, $this->formFactory);
    }

    /**
     * Очистка окружения
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->formFactory  = null;
        $this->loginService = null;
        $this->controller   = null;
    }

    /**
     * Проверяет вход в систему
     */
    public function testLogin()
    {
        $request          = $this->createRequest();
        $request->request = $this->createParameterBag();

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with($this->equalTo(LoginType::class))
            ->willReturn($loginForm = $this->createMock(FormInterface::class));

        $loginForm
            ->expects($this->once())
            ->method('handleRequest')
            ->with($this->identicalTo($request));

        $loginForm
            ->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(true);

        $loginForm
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $loginForm
            ->expects($this->once())
            ->method('getData')
            ->willReturn($loginData = ['some login data']);

        $this->loginService
            ->expects($this->once())
            ->method('login')
            ->with($this->equalTo($loginData))
            ->willReturn($response = $this->createMock(Response::class));

        $this->assertSame($response, $this->controller->login($request));
    }

    /**
     * Создает запрос
     *
     * @return MockObject|Request
     */
    private function createRequest(): Request
    {
        return $this->createMock(Request::class);
    }

    /**
     * Создает параметры запроса
     *
     * @return MockObject|ParameterBag
     */
    private function createParameterBag(): ParameterBag
    {
        return $this->createMock(ParameterBag::class);
    }
}