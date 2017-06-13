<?php

declare(strict_types = 1);

namespace Temirkhan\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Temirkhan\UserBundle\ValueObject\LoginCredentials;

/**
 * Форма входа в систему
 */
class LoginType extends AbstractType implements DataMapperInterface
{
    /**
     * Инициализация формы
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataMapper($this);

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
            'constraints' => [new NotBlank(['message' => 'Не указан пароль'])],
            'empty_data'  => '',
        ]);

        $builder->add('signIn', SubmitType::class);
    }

    /**
     * Заполняет форму данными
     *
     * @param mixed           $data
     * @param FormInterface[] $forms
     */
    public function mapDataToForms($data, $forms)
    {
        if (!$data) {
            $data = new LoginCredentials('', '');
        }

        $forms = iterator_to_array($forms);

        $forms['login']->setData($data->getLogin());
        $forms['password']->setData($data->getPassword());
    }

    /**
     * Заполняет объект данными из формы
     *
     * @param FormInterface[] $forms
     * @param mixed           $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $data = new LoginCredentials($forms['login']->getData(), $forms['password']->getData());
    }

    /**
     * Конфигурация формы
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => LoginCredentials::class,
            'empty_data'         => null,
            'error_bubbling'     => false,
        ]);
    }
}
