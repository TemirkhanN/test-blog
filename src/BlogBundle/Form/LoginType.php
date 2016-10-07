<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * Class LoginType
 * @package BlogBundle\Form
 */
class LoginType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                'label' => 'Логин',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('Войти', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-primary btn-block'
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BlogBundle\Entity\User'
        ]);
    }

}