<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Form;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;

/**
 * Тесты формы входа в систему
 */
class LoginTypeTest extends TestCase
{
    /**
     * Форма входа в систему
     *
     * @var LoginType
     */
    private $loginType;

    /**
     * Установка окружения
     */
    protected function setUp()
    {
        parent::setUp();

        $this->loginType = new LoginType();
    }

    /**
     * Очистка окружения
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->loginType = null;
    }

    /**
     * Проверяет инициализацию формы
     */
    public function testBuildForm()
    {
        $builder = $this->createBuilder();

        $builder
            ->expects($this->at(0))
            ->method('add')
            ->with(
                $this->equalTo('login'),
                $this->equalTo(TextType::class),
                $this->callback(function (array $options): bool {
                    $this->assertArrayHasKey('empty_data', $options);
                    $this->assertSame('', $options['empty_data']);

                    $this->assertArrayHasKey('constraints', $options);
                    $this->assertContainsOnlyInstancesOf(Constraint::class, $options['constraints']);

                    return true;
                })
            )
            ->willReturn($builder);

        $builder
            ->expects($this->at(1))
            ->method('add')
            ->with(
                $this->equalTo('password'),
                $this->equalTo(PasswordType::class),
                $this->callback(function (array $options): bool {
                    $this->assertArrayHasKey('empty_data', $options);
                    $this->assertSame('', $options['empty_data']);

                    $this->assertArrayHasKey('constraints', $options);
                    $this->assertContainsOnlyInstancesOf(Constraint::class, $options['constraints']);

                    return true;
                })
            )
            ->willReturn($builder);

        $this->loginType->buildForm($builder, []);
    }

    /**
     * Проверяет конфигурацию формы
     */
    public function testConfigureOptions()
    {
        $resolver = $this->createResolver();

        $resolver
            ->expects($this->once())
            ->method('setDefaults')
            ->with($this->callback(function (array $options): bool {
                $this->assertArrayHasKey('allow_extra_fields', $options);
                $this->assertFalse($options['allow_extra_fields']);

                $this->assertArrayHasKey('error_bubbling', $options);
                $this->assertFalse($options['error_bubbling']);

                return true;
            }));

        $this->loginType->configureOptions($resolver);
    }

    /**
     * Создает строителя формы
     *
     * @return MockObject|FormBuilderInterface
     */
    private function createBuilder(): FormBuilderInterface
    {
        return $this->createMock(FormBuilderInterface::class);
    }

    /**
     * Создает обработчик опций
     *
     * @return MockObject|OptionsResolver
     */
    private function createResolver(): OptionsResolver
    {
        return $this->createMock(OptionsResolver::class);
    }
}