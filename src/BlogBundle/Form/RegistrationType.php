<?php

declare(strict_types=1);

namespace BlogBundle\Form;

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
use Symfony\Component\Validator\Constraints\Regex;
use BlogBundle\ValueObject\RegistrationCredentials;

/**
 * Форма регистрации автора
 */
class RegistrationType extends AbstractType implements DataMapperInterface
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

        $builder->add('name', TextType::class, [
            'empty_data'  => '',
            'constraints' => [
                new NotBlank(['message' => 'Не указано имя']),
                new Length(['max' => 50, 'maxMessage' => 'Имя не может быть длиннее {{ limit }} символов']),
                new Regex(['pattern' => '/^[a-zа-я0-9_ ]+$/ui', 'message' => 'Имя содержит недопустимые символы']),
            ],
        ]);

        $builder->add('login', TextType::class, [
            'empty_data' => '',
            'constraints' => [
                new NotBlank(['message' => 'Логин не может быть пустым']),
                new Length([
                    'min' => 5,
                    'minMessage' => 'Логин не может быть короче {{ limit }} символов',
                    'max' => 32,
                    'maxMessage' => 'Логин не может быть длиннее {{ limit }} символов'
                ]),
                new Regex(['pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Логин содержит недопустимые символы']),
            ],
        ]);

        $builder->add('password', PasswordType::class, [
            'empty_data' => '',
            'constraints' => [
                new NotBlank(['message' => 'Пароль не может быть пустым']),
            ],
        ]);

        $builder->add('signUp', SubmitType::class);
    }

    /**
     * Устанавливает данные в форму
     *
     * @param mixed           $data
     * @param FormInterface[] $forms
     */
    public function mapDataToForms($data, $forms)
    {
        if (!$data) {
            $data = new RegistrationCredentials('', '', '');
        }

        $forms = iterator_to_array($forms);

        $forms['name']  = $data->getName();
        $forms['login'] = $data->getLogin();
    }

    /**
     * Устанавливает данные из формы
     *
     * @param FormInterface[] $forms
     * @param mixed           $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $data = new RegistrationCredentials(
            $forms['name']->getData(),
            $forms['login']->getData(),
            $forms['password']->getData()
        );
    }

    /**
     * Конфигурация формы
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'     => RegistrationCredentials::class,
            'empty_data'     => null,
            'error_bubbling' => false,
        ]);
    }
}
