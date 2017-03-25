<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Форма входа в систему
 */
class LoginType extends AbstractType
{
    /**
     * Инициализация формы
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Логин пуст']),
                new Length([
                    'max'        => 255,
                    'maxMessage' => 'Слишком длинный логин',
                ]),
            ],
            'empty_data' => '',
        ]);

        $builder->add('password', PasswordType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Не указан пароль'])
            ],
            'empty_data'  => '',
        ]);
    }

    /**
     * Конфигурация формы
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => false,
            'error_bubbling'     => false,
        ]);
    }
}