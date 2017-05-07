<?php

declare(strict_types = 1);

namespace BlogBundle\Form;

use BlogBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Форма публикации
 */
class PostType extends AbstractType
{

    /**
     * Инициализация формы
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'empty_data'  => '',
                'constraints' => [
                    new NotBlank(['message' => 'Не указан заголовок публикации']),
                    new Length(['max' => 255, 'maxMessage' => 'Заголовок не может быть длиннее {limit} символов']),
                ],
            ])
            ->add('teaser', TextareaType::class, [
                'empty_data'  => '',
                'constraints' => [
                    new NotBlank(['message' => 'Аннотация не может быть пустой']),
                    new Length(['max' => 255, 'maxMessage' => 'Аннотация не может быть длиннее {limit} символов']),
                ],
            ])
            ->add('content', TextareaType::class, [
                'empty_data'  => '',
                'constraints' => [
                    new NotBlank(['message' => 'Содержимое публикации не может быть пустым']),
                    new Length(['max' => 3000, 'maxMessage' => 'Публикация не может быть длиннее {limit} символов']),
                ],
            ])
            ->add('Сохранить', SubmitType::class);
    }

    /**
     * Конфигурация формы
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}