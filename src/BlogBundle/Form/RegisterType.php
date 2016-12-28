<?php
declare(strict_types = 1);

namespace BlogBundle\Form;

use BlogBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    /**
     * TODO извращения с аттрибутами полей должны быть в twig, но я его практически не знаю)
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Имя',
            'attr'  => [
                'class' => 'form-control',
            ],
            'validation_groups' => [
                'register',
            ],
        ]);
        $builder->add('login', TextType::class, [
            'label' => 'Логин',
            'attr'  => [
                'class' => 'form-control',
            ],
            'validation_groups' => [
                'register',
            ],
        ]);
        $builder->add('password', PasswordType::class, [
            'label' => 'Пароль',
            'attr'  => [
                'class' => 'form-control',
            ],
            'validation_groups' => [
                'register',
            ],
        ]);
        $builder->add('Зарегистрироваться', SubmitType::class, [
            'attr'  => [
                'value' => 'Зарегистрироваться',
                'class' => 'btn btn-lg btn-primary btn-block',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => User::class,
            'validation_groups' => [
                'register',
            ],
        ]);
    }
}